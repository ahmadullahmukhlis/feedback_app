import 'dart:async';
import 'package:aps_feedback/config/api_client.dart';
import 'package:flutter/material.dart';
import 'package:app_links/app_links.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:google_fonts/google_fonts.dart';
import 'home_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _storage = const FlutterSecureStorage();
  late AppLinks _appLinks;
  StreamSubscription<Uri>? _linkSubscription;

  bool _loading = false;
  String? _errorMessage;

  @override
  void initState() {
    super.initState();
    _initDeepLinks();
    _checkExistingToken();
  }

  void _initDeepLinks() {
    _appLinks = AppLinks();
    _linkSubscription = _appLinks.uriLinkStream.listen(
          (uri) {
        if (uri.scheme == 'myapp' &&
            uri.queryParameters.containsKey('token')) {
          _handleLoginSuccess(uri.queryParameters['token']!);
        } else if (uri.scheme == 'myapp' &&
            uri.queryParameters.containsKey('error')) {
          _handleLoginError(uri.queryParameters['error']!);
        }
      },
    );
  }

  Future<void> _checkExistingToken() async {
    final token = await _storage.read(key: 'auth_token');
    if (token != null && mounted) {
      Navigator.pushNamedAndRemoveUntil(
        context,
        '/home',
            (route) => false, // remove all previous routes
      );

      // Navigator.pushReplacement(
      //   context,
      //   MaterialPageRoute(builder: (_) => const HomeScreen()),
      // );
    }
  }

  Future<void> _handleLoginSuccess(String token) async {
    await _storage.write(key: 'auth_token', value: token);
    if (!mounted) return;
    setState(() => _loading = false);
    _loadMyData();
    Navigator.pushNamedAndRemoveUntil(
      context,
      '/home',
          (route) => false, // remove all previous routes
    );
    // Navigator.pushReplacement(
    //   context,
    //   MaterialPageRoute(builder: (_) => const HomeScreen()),
    // );
  }
  Future<void> _loadMyData() async {
    try {
      final response = await ApiClient.get('profile-me'); // Dio Response

      // ✅ Access data via .data
      final data = response.data as Map<String, dynamic>;
      print('PROFILE RESPONSE: $data');

      // 🔐 Save fields to secure storage
      await _storage.write(key: 'user_id', value: data['id'].toString());
      await _storage.write(key: 'user_name', value: data['name']);
      await _storage.write(key: 'user_email', value: data['email']);
      await _storage.write(key: 'user_image', value: data['image']);

    } catch (e) {
      debugPrint('Error loading profile: $e');
    }
  }

  void _handleLoginError(String error) {
    if (!mounted) return;
    setState(() {
      _loading = false;
      _errorMessage = error;
    });
  }

  Future<void> _loginWithGoogle() async {
    setState(() {
      _loading = true;
      _errorMessage = null;
    });

    final url =
    Uri.parse('http://10.60.76.77:8000/api/auth/google/redirect');

    if (!await launchUrl(
      url,
      mode: LaunchMode.externalApplication,
    )) {
      _showError('Could not launch login');
    }
  }

  void _showError(String message) {
    if (!mounted) return;
    setState(() {
      _loading = false;
      _errorMessage = message;
    });
  }

  @override
  void dispose() {
    _linkSubscription?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
                colors: [
                  Colors.blue.shade50,
                  Colors.white,
                ],
              ),
            ),
            child: SafeArea(
              child: Padding(
                padding: const EdgeInsets.symmetric(horizontal: 24),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    // LOGO
                    Container(
                      width: 150,
                      height: 150,
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(20),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.blue.withOpacity(0.1),
                            blurRadius: 20,
                            spreadRadius: 5,
                          ),
                        ],
                      ),
                      child: Image.asset(
                        'assets/logo.png',
                        height: 54,
                        width: 54,
                      ),
                    ),
                    const SizedBox(height: 20),

                    Text(
                      'Welcome Back',
                      style: GoogleFonts.poppins(
                        fontSize: 28,
                        fontWeight: FontWeight.bold,
                        color: Colors.blue.shade900,
                      ),
                    ),
                    const SizedBox(height: 8),
                    Text(
                      'Sign in to continue to your account and give us your feedback',
                      style: GoogleFonts.poppins(
                        fontSize: 16,
                        color: Colors.grey.shade600,
                      ),
                      textAlign: TextAlign.center,
                    ),

                    const SizedBox(height: 60),

                    // GOOGLE BUTTON
                    SizedBox(
                      width: double.infinity,
                      height: 56,
                      child: ElevatedButton(
                        onPressed: _loading ? null : _loginWithGoogle,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.white,
                          foregroundColor: Colors.grey.shade800,
                          elevation: 2,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                            side: BorderSide(
                              color: Colors.grey.shade300,
                            ),
                          ),
                        ),
                        child: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            if (_loading)
                              SizedBox(
                                width: 20,
                                height: 20,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                ),
                              )
                            else
                              Image.network(
                                'https://developers.google.com/identity/images/g-logo.png',
                                height: 24,
                                width: 24,
                              ),
                            const SizedBox(width: 12),
                            Flexible(
                              child: Text(
                                _loading
                                    ? 'Signing in...'
                                    : 'Continue with Google',
                                overflow: TextOverflow.ellipsis,
                                style: GoogleFonts.poppins(
                                  fontSize: 16,
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),

                    if (_errorMessage != null) ...[
                      const SizedBox(height: 20),
                      Text(
                        _errorMessage!,
                        style: GoogleFonts.poppins(
                          color: Colors.red,
                        ),
                        textAlign: TextAlign.center,
                      ),
                    ],

                    const SizedBox(height: 40),
                    Text(
                      'By continuing, you agree to our Terms of Service and Privacy Policy',
                      textAlign: TextAlign.center,
                      style: GoogleFonts.poppins(
                        fontSize: 12,
                        color: Colors.grey.shade600,
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),

          // LOADING OVERLAY
          if (_loading)
            Container(
              color: Colors.black.withOpacity(0.3),
              child: Center(
                child: Container(
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      const CircularProgressIndicator(),
                      const SizedBox(height: 12),
                      Text(
                        'Please complete login in browser...',
                        style: GoogleFonts.poppins(
                          fontSize: 14,
                          color: Colors.grey.shade700,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
        ],
      ),
    );
  }
}
