import 'dart:async';
import 'dart:convert';
import 'dart:io';

import 'package:aps_feedback/layouts/main_layout.dart';
import 'package:aps_feedback/services/notification_service.dart';
import 'package:aps_feedback/services/reverb_service.dart';
import 'package:aps_feedback/services/support_service.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:image_picker/image_picker.dart';

class SupportScreen extends StatefulWidget {
  const SupportScreen({super.key});

  @override
  State<SupportScreen> createState() => _SupportScreenState();
}

class _SupportScreenState extends State<SupportScreen> {
  static final _storage = const FlutterSecureStorage();
  final TextEditingController _messageController = TextEditingController();
  final FocusNode _focusNode = FocusNode();
  final ImagePicker _picker = ImagePicker();
  final ScrollController _scrollController = ScrollController();

  List<ChatMessage> _messages = [];
  bool _isLoadingMore = false;
  bool _hasMore = true;
  int _page = 0;
  final int _pageSize = 20;

  late ReverbService reverb;

  @override
  void initState() {
    super.initState();
    _initialize();

    _scrollController.addListener(() {
      if (_scrollController.position.pixels <=
          _scrollController.position.minScrollExtent + 50) {
        if (!_isLoadingMore && _hasMore) loadMoreMessages();
      }
    });

    FirebaseMessaging.onMessage.listen((message) async {
      final rawString = message.notification?.body ??
          (message.data.isNotEmpty ? message.data.toString() : 'New message');

      await NotificationService.showNotification(
        title: 'New Support Message',
        body: rawString,
      );
    });
  }

  Future<void> _initialize() async {
    await loadMessages();
    final token = await _storage.read(key: 'auth_token');

    reverb = ReverbService(
      host: '10.60.76.77',
      port: 8080,
      appKey: 'z0qhwyopf3pso4vt1crf',
      userToken: token ?? '',
      userId: 4,
    );

    await reverb.init();
    final userID = await _storage.read(key: "user_id");

    await reverb.subscribePublic('response-$userID', 'ResponseEvent', (event) async {
      try {
        final payload = jsonDecode(event as String) as Map<String, dynamic>;
        final response = payload['response'] as Map<String, dynamic>;
        await NotificationService.showNotification(
          title: 'New Message',
          body: response['message'] ?? "",
        );

        final newMsg = ChatMessage(
          text: response['message'] ?? '',
          isUser: response['isUser'] ?? false,
          imagePath: response['imagePath'],
          timestamp: DateTime.parse(response['created_at']),
        );

        setState(() => _messages.add(newMsg));
        _scrollToBottom();
      } catch (e, s) {
        print('❌ EVENT ERROR: $e');
        print(s);
      }
    });
  }

  Future<void> loadMessages() async {
    try {
      _page = 0;
      final response = await SupportService.get(_page, _pageSize);

      setState(() {
        _messages = response.isEmpty
            ? [
          ChatMessage(
            text:
            "Hello! Welcome to AfPay Support. How can we help you today?",
            isUser: false,
            timestamp:
            DateTime.now().subtract(const Duration(minutes: 5)),
          ),
        ]
            : response
            .map(
              (item) => ChatMessage(
            text: item['message'],
            isUser: item['isUser'] ?? false,
            timestamp: DateTime.parse(item['created_at']),
            imagePath: item['imagePath'],
          ),
        )
            .toList();
        _hasMore = response.length == _pageSize;
      });

      WidgetsBinding.instance.addPostFrameCallback((_) => _scrollToBottom());
    } catch (e) {
      print('Error loading messages: $e');
    }
  }

  Future<void> loadMoreMessages() async {
    if (!_hasMore) return;
    _isLoadingMore = true;
    _page++;

    try {
      final response = await SupportService.get(_page, _pageSize);

      setState(() {
        final olderMessages = response
            .map(
              (item) => ChatMessage(
            text: item['message'],
            isUser: item['isUser'] ?? false,
            timestamp: DateTime.parse(item['created_at']),
            imagePath: item['imagePath'],
          ),
        )
            .toList();
        _messages = [...olderMessages, ..._messages];
        _hasMore = response.length == _pageSize;
      });
    } catch (e) {
      print('Error loading more messages: $e');
    } finally {
      _isLoadingMore = false;
    }
  }

  void _sendMessage() async {
    if (_messageController.text.trim().isEmpty) return;
    final messageText = _messageController.text.trim();

    final newMessage = ChatMessage(
      text: messageText,
      isUser: true,
      timestamp: DateTime.now(),
    );

    setState(() => _messages.add(newMessage));
    _messageController.clear();
    _scrollToBottom();

    try {
      await SupportService.post(message: messageText);
    } catch (e) {
      print("Error sending message: $e");
    }
  }

  Future<void> _pickImage(ImageSource source) async {
    final XFile? pickedImage =
    await _picker.pickImage(source: source, imageQuality: 75);

    if (pickedImage != null) {
      final imageFile = File(pickedImage.path);
      final newMessage = ChatMessage(
        text: "Image sent",
        isUser: true,
        timestamp: DateTime.now(),
        imagePath: imageFile.path,
      );

      setState(() => _messages.add(newMessage));
      _scrollToBottom();

      try {
        await SupportService.post(
          message:
          "I have taken a photo of the issue. Please review and fix it.",
          image: imageFile,
        );
      } catch (e) {
        print("Error sending image: $e");
      }
    }
  }

  Future<void> _showImageSource() async {
    showModalBottomSheet(
      context: context,
      backgroundColor: Theme.of(context).colorScheme.surface,
      builder: (context) => SafeArea(
        child: Wrap(
          children: [
            ListTile(
              leading: Icon(Icons.camera_alt,
                  color: Theme.of(context).colorScheme.onSurface),
              title: Text('Take photo',
                  style:
                  TextStyle(color: Theme.of(context).colorScheme.onSurface)),
              onTap: () async {
                Navigator.of(context).pop();
                await _pickImage(ImageSource.camera);
              },
            ),
            ListTile(
              leading: Icon(Icons.photo_library,
                  color: Theme.of(context).colorScheme.onSurface),
              title: Text('Choose from gallery',
                  style:
                  TextStyle(color: Theme.of(context).colorScheme.onSurface)),
              onTap: () async {
                Navigator.of(context).pop();
                await _pickImage(ImageSource.gallery);
              },
            ),
          ],
        ),
      ),
    );
  }

  void _scrollToBottom() {
    if (_scrollController.hasClients) {
      _scrollController.animateTo(
        _scrollController.position.maxScrollExtent + 100,
        duration: const Duration(milliseconds: 300),
        curve: Curves.easeOut,
      );
    }
  }

  @override
  void dispose() {
    _messageController.dispose();
    _focusNode.dispose();
    _scrollController.dispose();
    reverb.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    final colorScheme = theme.colorScheme;
    final isDark = theme.brightness == Brightness.dark;

    return MainLayout(
      title: "Afghan Payment System",
      subtitle: "Support",
      currentIndex: 1,
      child: Column(
        children: [
          const SizedBox(height: 16),
          _buildChatHeader(colorScheme),
          const SizedBox(height: 8),
          Expanded(
            child: Container(
              color: isDark ? colorScheme.background : const Color(0xFFECE5DD),
              child: _buildChatMessages(colorScheme, isDark),
            ),
          ),
          _buildMessageInput(colorScheme, isDark),
        ],
      ),
    );
  }

  Widget _buildChatHeader(ColorScheme colorScheme) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: colorScheme.surface,
        borderRadius: BorderRadius.circular(10),
      ),
      child: Row(
        children: [
          Icon(Icons.circle, color: Colors.green, size: 10),
          const SizedBox(width: 8),
          Text("Online Support", style: TextStyle(color: colorScheme.onSurface))
        ],
      ),
    );
  }

  Widget _buildChatMessages(ColorScheme colorScheme, bool isDark) {
    return RefreshIndicator(
      onRefresh: _onRefresh,
      displacement: 40,
      color: const Color(0xFF128C7E),
      child: ListView.builder(
        controller: _scrollController,
        physics: const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 16),
        itemCount: _messages.length + (_isLoadingMore ? 1 : 0),
        itemBuilder: (context, index) {
          if (_isLoadingMore && index == 0) {
            return const Padding(
              padding: EdgeInsets.all(12),
              child: Center(
                child: SizedBox(
                  width: 20,
                  height: 20,
                  child: CircularProgressIndicator(strokeWidth: 2),
                ),
              ),
            );
          }
          final msgIndex = _isLoadingMore ? index - 1 : index;
          return _buildMessageBubble(_messages[msgIndex], msgIndex, colorScheme, isDark);
        },
      ),
    );
  }

  Widget _buildMessageBubble(ChatMessage message, int index, ColorScheme colorScheme, bool isDark) {
    final isSameUser =
        index > 0 && _messages[index - 1].isUser == message.isUser;

    final userColor = isDark ? const Color(0xFF056D4C) : const Color(0xFFDCF8C6);
    final supportColor = isDark ? Colors.grey[800]! : Colors.white;

    return Container(
      margin: EdgeInsets.only(bottom: 8, top: isSameUser ? 2 : 8),
      child: Row(
        mainAxisAlignment:
        message.isUser ? MainAxisAlignment.end : MainAxisAlignment.start,
        crossAxisAlignment: CrossAxisAlignment.end,
        children: [
          if (!message.isUser && !isSameUser)
            Container(
              margin: const EdgeInsets.only(right: 8, bottom: 4),
              child: CircleAvatar(
                backgroundColor: Colors.green,
                radius: 12,
                child: Icon(Icons.support_agent, size: 14, color: Colors.white),
              ),
            ),
          Flexible(
            child: Container(
              padding: const EdgeInsets.all(12),
              constraints: BoxConstraints(
                maxWidth: MediaQuery.of(context).size.width * 0.75,
              ),
              decoration: BoxDecoration(
                color: message.isUser ? userColor : supportColor,
                borderRadius: BorderRadius.only(
                  topLeft: const Radius.circular(18),
                  topRight: const Radius.circular(18),
                  bottomLeft: message.isUser
                      ? const Radius.circular(18)
                      : const Radius.circular(4),
                  bottomRight: message.isUser
                      ? const Radius.circular(4)
                      : const Radius.circular(18),
                ),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.1),
                    blurRadius: 2,
                    offset: const Offset(0, 1),
                  ),
                ],
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  if (message.imagePath != null)
                    ClipRRect(
                      borderRadius: BorderRadius.circular(8),
                      child: message.imagePath!.startsWith("http")
                          ? Image.network(
                        message.imagePath!,
                        height: 180,
                        width: double.infinity,
                        fit: BoxFit.cover,
                        errorBuilder: (context, error, stackTrace) {
                          return Container(
                            height: 180,
                            width: double.infinity,
                            color: Colors.grey[300],
                            child: Icon(Icons.broken_image,
                                color: Colors.grey[700]),
                          );
                        },
                      )
                          : Image.file(
                        File(message.imagePath!),
                        height: 180,
                        width: double.infinity,
                        fit: BoxFit.cover,
                      ),
                    ),
                  if (message.text != null && message.text!.isNotEmpty)
                    Padding(
                      padding: EdgeInsets.only(
                        top: message.imagePath != null ? 6 : 0,
                      ),
                      child: Text(
                        message.text!,
                        style: TextStyle(
                            fontSize: 16,
                            color: isDark ? Colors.white70 : Colors.black87),
                      ),
                    ),
                  const SizedBox(height: 4),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      Text(
                        _formatTime(message.timestamp),
                        style: TextStyle(
                            fontSize: 11,
                            color: isDark ? Colors.white54 : Colors.grey[600]),
                      ),
                      if (message.isUser) const SizedBox(width: 4),
                      if (message.isUser)
                        const Icon(Icons.done_all, size: 14, color: Colors.blue),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Future<void> _onRefresh() async {
    try {
      setState(() {
        _hasMore = true;
        _isLoadingMore = false;
        _page = 0;
      });

      await loadMessages();
    } catch (e) {
      debugPrint('Refresh error: $e');
    }
  }

  Widget _buildMessageInput(ColorScheme colorScheme, bool isDark) {
    final bgColor = isDark ? Colors.grey[900] : Colors.white;
    final inputColor = isDark ? Colors.grey[800] : Colors.grey[100];
    final hintColor = isDark ? Colors.white54 : Colors.grey;

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 8),
      color: bgColor,
      child: Row(
        children: [
          Container(
            decoration: BoxDecoration(
              color: inputColor,
              borderRadius: BorderRadius.circular(24),
            ),
            child: IconButton(
              onPressed: _showImageSource,
              icon: Icon(Icons.add, color: hintColor),
            ),
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Container(
              decoration: BoxDecoration(
                color: inputColor,
                borderRadius: BorderRadius.circular(24),
              ),
              child: Row(
                children: [
                  const SizedBox(width: 16),
                  Expanded(
                    child: TextField(
                      controller: _messageController,
                      focusNode: _focusNode,
                      textInputAction: TextInputAction.send,
                      onSubmitted: (_) => _sendMessage(),
                      style: TextStyle(
                          fontSize: 16, color: isDark ? Colors.white : Colors.black),
                      decoration: InputDecoration(
                        hintText: "Message",
                        border: InputBorder.none,
                        hintStyle: TextStyle(color: hintColor),
                      ),
                      maxLines: 5,
                      minLines: 1,
                    ),
                  ),
                  IconButton(
                    onPressed: () {},
                    icon: Icon(Icons.emoji_emotions_outlined, color: hintColor),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(width: 8),
          Container(
            decoration: BoxDecoration(
              color: const Color(0xFF128C7E),
              borderRadius: BorderRadius.circular(24),
            ),
            child: IconButton(
              onPressed: _sendMessage,
              icon: const Icon(Icons.send, color: Colors.white),
            ),
          ),
        ],
      ),
    );
  }

  String _formatTime(DateTime time) {
    final now = DateTime.now();
    final today = DateTime(now.year, now.month, now.day);
    final messageDate = DateTime(time.year, time.month, time.day);

    if (messageDate == today) {
      return "${time.hour.toString().padLeft(2, '0')}:${time.minute.toString().padLeft(2, '0')}";
    } else if (messageDate == today.subtract(const Duration(days: 1))) {
      return "Yesterday ${time.hour.toString().padLeft(2, '0')}:${time.minute.toString().padLeft(2, '0')}";
    } else {
      return "${time.day}/${time.month}/${time.year.toString().substring(2)} ${time.hour.toString().padLeft(2, '0')}:${time.minute.toString().padLeft(2, '0')}";
    }
  }
}

class ChatMessage {
  final String? text;
  final bool isUser;
  final DateTime timestamp;
  final String? imagePath;

  ChatMessage({
    this.text,
    required this.isUser,
    required this.timestamp,
    this.imagePath,
  });
}
