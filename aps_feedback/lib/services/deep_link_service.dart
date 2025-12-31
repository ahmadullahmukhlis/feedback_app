import 'dart:async';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:app_links/app_links.dart';

class DeepLinkService {
  static final _storage = FlutterSecureStorage();
  static final AppLinks _appLinks = AppLinks();
  static StreamSubscription<Uri>? _sub;

  /// Initialize the deep link listener
  static Future<void> init() async {
    // 1️⃣ Handle app opened from terminated state
    final uri = await _appLinks.getInitialLink();
    if (uri != null) {
      await _handleUri(uri);
    }

    // 2️⃣ Handle app opened while already running
    _sub = _appLinks.uriLinkStream.listen((Uri uri) {
      _handleUri(uri);
    }, onError: (err) {
      // handle errors if needed
    });
  }

  /// Handle incoming URI and save the token
  static Future<void> _handleUri(Uri uri) async {
    final token = uri.queryParameters['token'];
    if (token != null) {
      await _storage.write(key: 'auth_token', value: token);
    }
  }

  /// Cancel the listener
  static void dispose() {
    _sub?.cancel();
  }

  /// Helper to read the token anywhere in the app
  static Future<String?> getToken() async {
    return await _storage.read(key: 'auth_token');
  }
}
