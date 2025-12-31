import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class NotificationService {
  static final _flutterLocalNotificationsPlugin = FlutterLocalNotificationsPlugin();

  static Future<void> init() async {
    const androidSettings = AndroidInitializationSettings('@mipmap/ic_launcher');
    const iOSSettings = DarwinInitializationSettings();
    const settings = InitializationSettings(android: androidSettings, iOS: iOSSettings);

    await _flutterLocalNotificationsPlugin.initialize(settings);
  }

  // Updated method to accept either RemoteMessage or title/body
  static Future<void> showNotification({
    RemoteMessage? message,
    String? title,
    String? body,
  }) async {
    final notifTitle = message?.notification?.title ?? title ?? 'New Message';
    final notifBody = message?.notification?.body ?? body ?? 'You have a new message';

    const androidDetails = AndroidNotificationDetails(
      'channel_id',
      'channel_name',
      importance: Importance.max,
      priority: Priority.high,
      playSound: true,
    );

    const iosDetails = DarwinNotificationDetails();

    const notificationDetails = NotificationDetails(android: androidDetails, iOS: iosDetails);

    await _flutterLocalNotificationsPlugin.show(
      DateTime.now().millisecondsSinceEpoch ~/ 1000, // unique ID
      notifTitle,
      notifBody,
      notificationDetails,
    );
  }
}
