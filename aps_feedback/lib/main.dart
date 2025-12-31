import 'package:aps_feedback/routes/app_routes.dart';
import 'package:aps_feedback/screens/home_screen.dart';
import 'package:aps_feedback/screens/login_screen.dart';
import 'package:aps_feedback/services/notification_service.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'firebase_options.dart'; // ← Import generated file
import 'package:aps_feedback/screens/globals.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'generated/l10n.dart';
/// Background handler must be top-level
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  // Initialize Firebase for background isolate
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );
  await NotificationService.showNotification(message: message);
}

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Initialize Firebase
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );

  // Initialize local notifications
  await NotificationService.init();
  await initAppLocale();
  await initAppTheme();
  // Background message handler
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ValueListenableBuilder<ThemeMode>(
      valueListenable: appTheme,
      builder: (context, themeMode, _) {
        return ValueListenableBuilder<Locale>(
          valueListenable: appLocale,
          builder: (context, locale, _) {
            return MaterialApp(
              title: 'Aps Feedback',
              debugShowCheckedModeBanner: false,
              theme: ThemeData.light(),
              darkTheme: ThemeData.dark(),
              themeMode: themeMode,
              locale: locale,
              supportedLocales: const [
                Locale('en'),
                Locale('fa'),
                Locale('ps'),
              ],
              localizationsDelegates: const [
                S.delegate,
                GlobalMaterialLocalizations.delegate,
                GlobalWidgetsLocalizations.delegate,
                GlobalCupertinoLocalizations.delegate,
              ],
              home: const SplashScreen(),
              onGenerateRoute: AppRoutes.generateRoute,
            );
          },
        );
      },
    );
  }
}



/// SplashScreen decides whether to show Login or Home
class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  final _storage = const FlutterSecureStorage();

  @override
  void initState() {
    super.initState();
    _checkAuth();

    // Foreground Firebase messages
    FirebaseMessaging.onMessage.listen((message) async {
      await NotificationService.showNotification(message: message);
    });
  }

  Future<void> _checkAuth() async {
    final token = await _storage.read(key: 'auth_token');

    if (token != null && token.isNotEmpty) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const HomeScreen()),
      );
    } else {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const LoginScreen()),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return const Scaffold(
      body: Center(child: CircularProgressIndicator()),
    );
  }
}
