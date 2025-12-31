import 'package:aps_feedback/config/api_client.dart';
import 'package:aps_feedback/layouts/main_layout.dart';
import 'package:aps_feedback/screens/about_screen.dart';
import 'package:aps_feedback/screens/help_support_screen.dart';
import 'package:aps_feedback/screens/privacy_security_screen.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:aps_feedback/screens/globals.dart';
import 'package:aps_feedback/generated/l10n.dart';

class SettingsScreen extends StatefulWidget {
  const SettingsScreen({super.key});

  @override
  State<SettingsScreen> createState() => _SettingsScreenState();
}

class _SettingsScreenState extends State<SettingsScreen> {
  final _storage = const FlutterSecureStorage();
  String? _selectedLanguage;
  String? _selectedTheme;
  String? name;
  String? email;
  String? imageUrl;
  bool _notificationsEnabled = false;

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  Future<void> _loadUserData() async {
    final storedName = await _storage.read(key: 'user_name');
    final storedEmail = await _storage.read(key: 'user_email');
    final storedImage = await _storage.read(key: 'user_image');
    final language = await _storage.read(key: 'language');
    final theme = await _storage.read(key: 'theme');
    bool hasPermission = await checkNotificationPermission();

    setState(() {
      name = storedName;
      email = storedEmail;
      imageUrl = storedImage;
      _selectedLanguage = language ?? 'English (US)';
      _selectedTheme = theme ?? 'System Default';
      _notificationsEnabled = hasPermission;
    });
  }

  Future<bool> checkNotificationPermission() async {
    NotificationSettings settings =
    await FirebaseMessaging.instance.getNotificationSettings();
    return settings.authorizationStatus == AuthorizationStatus.authorized ||
        settings.authorizationStatus == AuthorizationStatus.provisional;
  }

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    final colorScheme = theme.colorScheme;

    return MainLayout(
      title: "Afghan Payment System",
      subtitle: "Settings",
      currentIndex: 1,
      child: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(vertical: 16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildUserProfileCard(context, colorScheme),
            const SizedBox(height: 16),
            _buildSettingsSection(context, colorScheme),
            const SizedBox(height: 16),
            _buildSupportSection(context, colorScheme),
            const SizedBox(height: 16),
            _buildAppInfoSection(context, colorScheme),
          ],
        ),
      ),
    );
  }

  Widget _buildUserProfileCard(BuildContext context, ColorScheme colorScheme) {
    if (name == null || email == null || imageUrl == null) {
      return Center(
        child: Padding(
          padding: const EdgeInsets.symmetric(vertical: 40),
          child: CircularProgressIndicator(color: colorScheme.primary),
        ),
      );
    }

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: colorScheme.surface, // adapts to dark mode
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: colorScheme.shadow.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        children: [
          Stack(
            children: [
              Container(
                width: 80,
                height: 80,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  border: Border.all(color: colorScheme.primary.withOpacity(0.3), width: 2),
                ),
                child: ClipOval(
                  child: Image.network(
                    imageUrl!,
                    fit: BoxFit.cover,
                    errorBuilder: (context, error, stackTrace) => Container(
                      color: colorScheme.primaryContainer,
                      child: Icon(Icons.person, size: 40, color: colorScheme.primary),
                    ),
                  ),
                ),
              ),
              Positioned(
                bottom: 0,
                right: 0,
                child: GestureDetector(
                  onTap: () {},
                  child: Container(
                    padding: const EdgeInsets.all(6),
                    decoration: BoxDecoration(
                      color: colorScheme.primary,
                      shape: BoxShape.circle,
                      border: Border.all(color: colorScheme.onPrimary, width: 2),
                    ),
                    child: Icon(Icons.camera_alt, size: 16, color: colorScheme.onPrimary),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  name ?? 'ahmadullah mukhlis',
                  style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.w700,
                      color: colorScheme.onSurface),
                ),
                const SizedBox(height: 2),
                Text(
                  email ?? 'ahmadullahmukhlis2019@gmail.com',
                  style: TextStyle(fontSize: 14, color: colorScheme.onSurfaceVariant),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSettingsSection(BuildContext context, ColorScheme colorScheme) {
    return _buildSectionContainer(
      child: Column(
        children: [
          _buildSettingItem(
            icon: Icons.notifications_outlined,
            title: S.of(context).notification,
            subtitle: S.of(context).notification_mn,
            trailing: Switch(
              value: _notificationsEnabled,
              onChanged: (value) async {
                if (value) {
                  NotificationSettings settings =
                  await FirebaseMessaging.instance.requestPermission(
                    alert: true,
                    badge: true,
                    sound: true,
                  );

                  setState(() {
                    _notificationsEnabled =
                        settings.authorizationStatus == AuthorizationStatus.authorized;
                  });

                  if (!_notificationsEnabled) {
                    ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(content: Text(S.of(context).notification_p)),
                    );
                  }
                } else {
                  setState(() {
                    _notificationsEnabled = false;
                  });
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(content: Text(S.of(context).notification_c)),
                  );
                }
              },
              activeColor: Colors.blue, // <-- force blue here
            ),
          ),
          _buildSettingItem(
            icon: Icons.language_outlined,
            title: S.of(context).language,
            subtitle: _selectedLanguage,
            onTap: () => _showLanguageSelection(context),
          ),
          _buildSettingItem(
            icon: Icons.dark_mode_outlined,
            title: S.of(context).theme,
            subtitle: _selectedTheme,
            onTap: () => _showThemeSelection(context),
          ),
          _buildSettingItem(
            icon: Icons.privacy_tip_outlined,
            title: S.of(context).privacy_security,
            onTap: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => const PrivacySecurityScreen(),
                ),
              );
            },
          ),
        ],
      ),
      bgColor: colorScheme.surface,
    );
  }

  Widget _buildSupportSection(BuildContext context, ColorScheme colorScheme) {
    return _buildSectionContainer(
      child: Column(
        children: [
          _buildSettingItem(
            icon: Icons.help_outline,
            title: S.of(context).help_support,
            onTap: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => const HelpSupportScreen(),
                ),
              );
            },
          ),
          _buildSettingItem(
            icon: Icons.info_outline,
            title: S.of(context).about,
            onTap: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => const AboutScreen(),
                ),
              );
            },
          ),
        ],
      ),
      bgColor: colorScheme.surface,
    );
  }

  Widget _buildAppInfoSection(BuildContext context, ColorScheme colorScheme) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      child: Column(
        children: [
          SizedBox(
            width: double.infinity,
            child: OutlinedButton.icon(
              onPressed: () => _showLogoutDialog(context),
              icon: Icon(Icons.logout, color: colorScheme.error),
              label: Text(S.of(context).logout,
                  style: TextStyle(color: colorScheme.error)),
              style: OutlinedButton.styleFrom(
                padding: const EdgeInsets.symmetric(vertical: 16),
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12)),
                side: BorderSide(color: colorScheme.error.withOpacity(0.3)),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSectionContainer({required Widget child, Color? bgColor}) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.symmetric(vertical: 8),
      decoration: BoxDecoration(
        color: bgColor ?? Theme.of(context).colorScheme.surface,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
              color: Colors.black.withOpacity(0.05),
              blurRadius: 10,
              offset: const Offset(0, 4))
        ],
      ),
      child: child,
    );
  }

  Widget _buildSettingItem(
      {required IconData icon,
        required String title,
        String? subtitle,
        Widget? trailing,
        VoidCallback? onTap}) {
    final colorScheme = Theme.of(context).colorScheme;

    return Column(
      children: [
        ListTile(
          contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
          leading: Container(
            width: 40,
            height: 40,
            decoration: BoxDecoration(
              color: Colors.blue.withOpacity(0.1), // <-- hardcoded
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: Colors.blue[600]), // <-- also hardcoded
          ),
          title: Text(title,
              style: TextStyle(
                  fontSize: 16, fontWeight: FontWeight.w500, color: colorScheme.onSurface)),
          subtitle: subtitle != null
              ? Text(subtitle,
              style: TextStyle(fontSize: 14, color: colorScheme.onSurfaceVariant))
              : null,
          trailing: trailing ??
              Icon(
                Icons.chevron_right,
                color: colorScheme.onSurfaceVariant,
              ),
          onTap: onTap,
        ),
        if (onTap != null)
          Divider(
            height: 1,
            thickness: 1,
            color: colorScheme.outline.withOpacity(0.3),
            indent: 72,
          ),
      ],
    );
  }

  void _showLogoutDialog(BuildContext context) {
    final colorScheme = Theme.of(context).colorScheme;
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (dialogContext) => AlertDialog(
        title: Text('Logout',
            style: TextStyle(fontWeight: FontWeight.w600, color: colorScheme.onSurface)),
        content: Text('Are you sure you want to logout?',
            style: TextStyle(color: colorScheme.onSurfaceVariant)),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(dialogContext),
            child: Text('Cancel',
                style: TextStyle(color: colorScheme.onSurfaceVariant)),
          ),
          TextButton(
            onPressed: () async {
              Navigator.pop(dialogContext);
              await _logout();
            },
            child: Text('Logout', style: TextStyle(color: colorScheme.error)),
          ),
        ],
      ),
    );
  }

  Future<void> _logout() async {
    try {
      final response = await ApiClient.post('/logout', []);
      if (response.statusCode == 204) {
        const storage = FlutterSecureStorage();
        await storage.delete(key: 'auth_token');
        await storage.delete(key: 'user_name');
        await storage.delete(key: 'user_email');
        Navigator.pushNamedAndRemoveUntil(
            context, '/login', (route) => false);
      }
    } catch (e) {
      debugPrint('Logout failed: $e');
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("You cannot log out now. An error occurred.")),
      );

    }
  }

  Future<void> _setLanguage(String displayName, String code) async {
    await _storage.write(key: 'language', value: displayName);
    await _storage.write(key: 'lang', value: code);
    setState(() => _selectedLanguage = displayName);
    appLocale.value = Locale(code);
  }

  void _showLanguageSelection(BuildContext context) {
    showModalBottomSheet(
      context: context,
      backgroundColor: Theme.of(context).colorScheme.surface,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(16)),
      ),
      builder: (context) {
        return Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const SizedBox(height: 16),
            Text('Select Language',
                style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.w600,
                    color: Theme.of(context).colorScheme.onSurface)),
            Divider(color: Theme.of(context).colorScheme.outline),
            _languageOption('English (US)', 'en'),
            _languageOption('Dari (AF)', 'fa'),
            _languageOption('Pashto (AF)', 'ps'),
            const SizedBox(height: 16),
          ],
        );
      },
    );
  }

  Widget _languageOption(String displayName, String code) {
    final colorScheme = Theme.of(context).colorScheme;
    return ListTile(
      title: Text(displayName, style: TextStyle(color: colorScheme.onSurface)),
      trailing: _selectedLanguage == displayName
          ? Icon(Icons.check, color: colorScheme.primary)
          : null,
      onTap: () {
        _setLanguage(displayName, code);
        Navigator.pop(context);
      },
    );
  }

  Future<void> _setTheme(String themeName, String themeCode) async {
    await _storage.write(key: 'theme', value: themeName);
    await _storage.write(key: 'theme_code', value: themeCode);
    setState(() => _selectedTheme = themeName);

    switch (themeCode) {
      case 'light':
        appTheme.value = ThemeMode.light;
        break;
      case 'dark':
        appTheme.value = ThemeMode.dark;
        break;
      default:
        appTheme.value = ThemeMode.system;
    }
  }

  void _showThemeSelection(BuildContext context) {
    final colorScheme = Theme.of(context).colorScheme;
    showModalBottomSheet(
      context: context,
      backgroundColor: colorScheme.surface,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(16)),
      ),
      builder: (context) {
        return Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const SizedBox(height: 16),
            Text('Select Theme',
                style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.w600,
                    color: colorScheme.onSurface)),
            Divider(color: colorScheme.outline),
            _themeOption('Light', 'light'),
            _themeOption('Dark', 'dark'),
            _themeOption('System Default', 'system'),
            const SizedBox(height: 16),
          ],
        );
      },
    );
  }

  Widget _themeOption(String displayName, String code) {
    final colorScheme = Theme.of(context).colorScheme;
    return ListTile(
      title: Text(displayName, style: TextStyle(color: colorScheme.onSurface)),
      trailing: _selectedTheme == displayName
          ? Icon(Icons.check, color: colorScheme.primary)
          : null,
      onTap: () {
        _setTheme(displayName, code);
        Navigator.pop(context);
      },
    );
  }
}
