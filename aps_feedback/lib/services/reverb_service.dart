import 'dart:async';
import 'package:dart_pusher_channels/dart_pusher_channels.dart';

class ReverbService {
  late PusherChannelsClient client;
  final Map<String, StreamSubscription<ChannelReadEvent>> _subscriptions = {};

  final String host;
  final int port;
  final String appKey;
  final String userToken;
  final int userId;

  ReverbService({
    required this.host,
    required this.port,
    required this.appKey,
    required this.userToken,
    required this.userId,
  });

  Future<void> init() async {
    print('Connecting to Reverb: ws://$host:$port, appKey: $appKey, userId: $userId');

    final hostOptions = PusherChannelsOptions.fromHost(
      scheme: 'ws', // Use 'wss' for TLS/SSL
      host: host,   // Only IP or hostname
      key: appKey,
      shouldSupplyMetadataQueries: true,
      metadata: PusherChannelsOptionsMetadata.byDefault(),
      port: port,
    );

    client = PusherChannelsClient.websocket(
      options: hostOptions,
      connectionErrorHandler: (exception, trace, refresh) {
        print('Connection error: $exception'); // <-- THIS IS WHERE your SocketException is printed
        refresh(); // Retry connection
      },
    );

    client.onConnectionEstablished.listen((_) {
      print('✅ Reverb connection established');
    });

    await client.connect(); // <-- The connection attempt happens here


    await client.connect();
  }

  /// Subscribe to a public channel
  Future<void> subscribePublic(String channelName, String eventName, void Function(dynamic) onEvent) async {
    final channel = client.publicChannel(channelName);

    _subscriptions[channelName] = channel.bind(eventName).listen((event) {
      onEvent(event.data);
    });

    channel.subscribe();
  }

  /// Subscribe to a private channel
  Future<void> subscribePrivate(String channelName, String eventName, void Function(dynamic) onEvent) async {
    final channel = client.privateChannel(
      channelName,
      authorizationDelegate:
      EndpointAuthorizableChannelTokenAuthorizationDelegate.forPrivateChannel(
        authorizationEndpoint: Uri.parse('http://$host:8000/api/broadcasting/auth'),
        headers: {'Authorization': 'Bearer $userToken'},
      ),
    );

    _subscriptions[channelName] = channel.bind(eventName).listen((event) {
      print('🔒 Private event received on $channelName: ${event.data}');
      onEvent(event.data);
    });

    channel.subscribe();
  }

  /// Unsubscribe from a specific channel
  Future<void> unsubscribe(String channelName) async {
    await _subscriptions[channelName]?.cancel();
    _subscriptions.remove(channelName);
    print('Unsubscribed from channel: $channelName');
  }

  /// Dispose all subscriptions and disconnect
  Future<void> dispose() async {
    for (var sub in _subscriptions.values) {
      await sub.cancel();
    }
    _subscriptions.clear();
    await client.disconnect();
    print('Reverb connection closed');
  }
}
