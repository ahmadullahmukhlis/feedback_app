// GENERATED CODE - DO NOT MODIFY BY HAND
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'intl/messages_all.dart';

// **************************************************************************
// Generator: Flutter Intl IDE plugin
// Made by Localizely
// **************************************************************************

// ignore_for_file: non_constant_identifier_names, lines_longer_than_80_chars
// ignore_for_file: join_return_with_assignment, prefer_final_in_for_each
// ignore_for_file: avoid_redundant_argument_values, avoid_escaping_inner_quotes

class S {
  S();

  static S? _current;

  static S get current {
    assert(
      _current != null,
      'No instance of S was loaded. Try to initialize the S delegate before accessing S.current.',
    );
    return _current!;
  }

  static const AppLocalizationDelegate delegate = AppLocalizationDelegate();

  static Future<S> load(Locale locale) {
    final name = (locale.countryCode?.isEmpty ?? false)
        ? locale.languageCode
        : locale.toString();
    final localeName = Intl.canonicalizedLocale(name);
    return initializeMessages(localeName).then((_) {
      Intl.defaultLocale = localeName;
      final instance = S();
      S._current = instance;

      return instance;
    });
  }

  static S of(BuildContext context) {
    final instance = S.maybeOf(context);
    assert(
      instance != null,
      'No instance of S present in the widget tree. Did you add S.delegate in localizationsDelegates?',
    );
    return instance!;
  }

  static S? maybeOf(BuildContext context) {
    return Localizations.of<S>(context, S);
  }

  /// `Home`
  String get home {
    return Intl.message('Home', name: 'home', desc: '', args: []);
  }

  /// `Settings`
  String get settings {
    return Intl.message('Settings', name: 'settings', desc: '', args: []);
  }

  /// `Afghan Payment System`
  String get app_name {
    return Intl.message(
      'Afghan Payment System',
      name: 'app_name',
      desc: '',
      args: [],
    );
  }

  /// `Services`
  String get services {
    return Intl.message('Services', name: 'services', desc: '', args: []);
  }

  /// `Support`
  String get support {
    return Intl.message('Support', name: 'support', desc: '', args: []);
  }

  /// `Notification`
  String get notification {
    return Intl.message(
      'Notification',
      name: 'notification',
      desc: '',
      args: [],
    );
  }

  /// `Manage your notifications`
  String get notification_mn {
    return Intl.message(
      'Manage your notifications',
      name: 'notification_mn',
      desc: '',
      args: [],
    );
  }

  /// `Notification permission denied!`
  String get notification_p {
    return Intl.message(
      'Notification permission denied!',
      name: 'notification_p',
      desc: '',
      args: [],
    );
  }

  /// `To disable notifications, change system settings.`
  String get notification_c {
    return Intl.message(
      'To disable notifications, change system settings.',
      name: 'notification_c',
      desc: '',
      args: [],
    );
  }

  /// `Language`
  String get language {
    return Intl.message('Language', name: 'language', desc: '', args: []);
  }

  /// `Theme`
  String get theme {
    return Intl.message('Theme', name: 'theme', desc: '', args: []);
  }

  /// `Privacy & Security`
  String get privacy_security {
    return Intl.message(
      'Privacy & Security',
      name: 'privacy_security',
      desc: '',
      args: [],
    );
  }

  /// `Help & Support`
  String get help_support {
    return Intl.message(
      'Help & Support',
      name: 'help_support',
      desc: '',
      args: [],
    );
  }

  /// `About`
  String get about {
    return Intl.message('About', name: 'about', desc: '', args: []);
  }

  /// `Logout`
  String get logout {
    return Intl.message('Logout', name: 'logout', desc: '', args: []);
  }

  /// `Customer Support`
  String get customer_support {
    return Intl.message(
      'Customer Support',
      name: 'customer_support',
      desc: '',
      args: [],
    );
  }

  /// `If you need help or have questions about using Afghan Payment System, our support team is ready to assist you. We aim to respond as quickly as possible.`
  String get customer_supprt_d {
    return Intl.message(
      'If you need help or have questions about using Afghan Payment System, our support team is ready to assist you. We aim to respond as quickly as possible.',
      name: 'customer_supprt_d',
      desc: '',
      args: [],
    );
  }

  /// `Contact Us`
  String get contact_us {
    return Intl.message('Contact Us', name: 'contact_us', desc: '', args: []);
  }

  /// `You can contact our support team through the app or via email. Please provide detailed information so we can assist you effectively.\nphone:+93779404681\nemail:ahmadullah.mukhlis@aps.gov.af`
  String get contact_us_d {
    return Intl.message(
      'You can contact our support team through the app or via email. Please provide detailed information so we can assist you effectively.\nphone:+93779404681\nemail:ahmadullah.mukhlis@aps.gov.af',
      name: 'contact_us_d',
      desc: '',
      args: [],
    );
  }

  /// `Report a Problem`
  String get report_a_problem {
    return Intl.message(
      'Report a Problem',
      name: 'report_a_problem',
      desc: '',
      args: [],
    );
  }

  /// `If you notice any unusual activity or technical issues, please go to the support page and message us immediately. Your feedback helps us improve our service.`
  String get report_a_problem_d {
    return Intl.message(
      'If you notice any unusual activity or technical issues, please go to the support page and message us immediately. Your feedback helps us improve our service.',
      name: 'report_a_problem_d',
      desc: '',
      args: [],
    );
  }

  /// `App Updates`
  String get app_updates {
    return Intl.message('App Updates', name: 'app_updates', desc: '', args: []);
  }

  /// `We regularly update the app to improve performance, security, and features. Make sure you are using the latest version for the best experience.`
  String get app_updates_d {
    return Intl.message(
      'We regularly update the app to improve performance, security, and features. Make sure you are using the latest version for the best experience.',
      name: 'app_updates_d',
      desc: '',
      args: [],
    );
  }

  /// `No News available`
  String get no_news_available {
    return Intl.message(
      'No News available',
      name: 'no_news_available',
      desc: '',
      args: [],
    );
  }

  /// `No services available`
  String get no_services_available {
    return Intl.message(
      'No services available',
      name: 'no_services_available',
      desc: '',
      args: [],
    );
  }

  /// `Privacy & Security`
  String get privacy_security_title {
    return Intl.message(
      'Privacy & Security',
      name: 'privacy_security_title',
      desc: '',
      args: [],
    );
  }

  /// `Information We Collect`
  String get information_we_collect_title {
    return Intl.message(
      'Information We Collect',
      name: 'information_we_collect_title',
      desc: '',
      args: [],
    );
  }

  /// `How We Use Your Information`
  String get how_we_use_info_title {
    return Intl.message(
      'How We Use Your Information',
      name: 'how_we_use_info_title',
      desc: '',
      args: [],
    );
  }

  /// `Data Storage and Protection`
  String get data_storage_title {
    return Intl.message(
      'Data Storage and Protection',
      name: 'data_storage_title',
      desc: '',
      args: [],
    );
  }

  /// `Network and API Security`
  String get network_api_title {
    return Intl.message(
      'Network and API Security',
      name: 'network_api_title',
      desc: '',
      args: [],
    );
  }

  /// `User Control and Transparency`
  String get user_control_title {
    return Intl.message(
      'User Control and Transparency',
      name: 'user_control_title',
      desc: '',
      args: [],
    );
  }

  /// `Third-Party Services`
  String get third_party_title {
    return Intl.message(
      'Third-Party Services',
      name: 'third_party_title',
      desc: '',
      args: [],
    );
  }

  /// `Updates and Support`
  String get updates_support_title {
    return Intl.message(
      'Updates and Support',
      name: 'updates_support_title',
      desc: '',
      args: [],
    );
  }

  /// `At Afghan Payment System, your privacy and security are our highest priorities. We are committed to protecting your personal information and ensuring that your experience with our application is safe, secure, and transparent.`
  String get privacy_security_text {
    return Intl.message(
      'At Afghan Payment System, your privacy and security are our highest priorities. We are committed to protecting your personal information and ensuring that your experience with our application is safe, secure, and transparent.',
      name: 'privacy_security_text',
      desc: '',
      args: [],
    );
  }

  /// `We only collect information that is necessary to provide and improve our services. This may include basic user details such as your name, email address, profile image, language preference, and app settings. We do not collect unnecessary personal data.`
  String get information_we_collect_text {
    return Intl.message(
      'We only collect information that is necessary to provide and improve our services. This may include basic user details such as your name, email address, profile image, language preference, and app settings. We do not collect unnecessary personal data.',
      name: 'information_we_collect_text',
      desc: '',
      args: [],
    );
  }

  /// `Your information is used solely to enhance your experience within the app. This includes personalizing content, saving preferences, and delivering relevant notifications. We do not sell or share your personal data with third parties.`
  String get how_we_use_info_text {
    return Intl.message(
      'Your information is used solely to enhance your experience within the app. This includes personalizing content, saving preferences, and delivering relevant notifications. We do not sell or share your personal data with third parties.',
      name: 'how_we_use_info_text',
      desc: '',
      args: [],
    );
  }

  /// `All sensitive data is securely stored using encrypted storage mechanisms. We follow industry-standard security practices to prevent unauthorized access, data loss, or misuse of information.`
  String get data_storage_text {
    return Intl.message(
      'All sensitive data is securely stored using encrypted storage mechanisms. We follow industry-standard security practices to prevent unauthorized access, data loss, or misuse of information.',
      name: 'data_storage_text',
      desc: '',
      args: [],
    );
  }

  /// `Communication between your device and our servers is protected using secure network protocols. We continuously monitor our systems to minimize security risks.`
  String get network_api_text {
    return Intl.message(
      'Communication between your device and our servers is protected using secure network protocols. We continuously monitor our systems to minimize security risks.',
      name: 'network_api_text',
      desc: '',
      args: [],
    );
  }

  /// `You have full control over your data. You can update your profile, change language or theme settings, and log out at any time. Locally stored data can be removed by logging out of the app.`
  String get user_control_text {
    return Intl.message(
      'You have full control over your data. You can update your profile, change language or theme settings, and log out at any time. Locally stored data can be removed by logging out of the app.',
      name: 'user_control_text',
      desc: '',
      args: [],
    );
  }

  /// `We may use trusted third-party services to support app functionality. These services comply with strict privacy and security standards.`
  String get third_party_text {
    return Intl.message(
      'We may use trusted third-party services to support app functionality. These services comply with strict privacy and security standards.',
      name: 'third_party_text',
      desc: '',
      args: [],
    );
  }

  /// `This policy may be updated from time to time to reflect improvements or regulatory changes. If you have any questions or concerns, please contact our support team.`
  String get updates_support_text {
    return Intl.message(
      'This policy may be updated from time to time to reflect improvements or regulatory changes. If you have any questions or concerns, please contact our support team.',
      name: 'updates_support_text',
      desc: '',
      args: [],
    );
  }

  /// `About the App`
  String get about_app_title {
    return Intl.message(
      'About the App',
      name: 'about_app_title',
      desc: '',
      args: [],
    );
  }

  /// `Afghan Payment System is a secure and user-friendly digital platform designed to simplify payments and financial interactions. Our goal is to provide fast, reliable, and accessible services for users across Afghanistan.`
  String get about_app_content {
    return Intl.message(
      'Afghan Payment System is a secure and user-friendly digital platform designed to simplify payments and financial interactions. Our goal is to provide fast, reliable, and accessible services for users across Afghanistan.',
      name: 'about_app_content',
      desc: '',
      args: [],
    );
  }

  /// `Our Mission`
  String get our_mission_title {
    return Intl.message(
      'Our Mission',
      name: 'our_mission_title',
      desc: '',
      args: [],
    );
  }

  /// `Our mission is to empower individuals and businesses by providing modern, secure, and transparent payment solutions that support financial inclusion and digital growth.`
  String get our_mission_content {
    return Intl.message(
      'Our mission is to empower individuals and businesses by providing modern, secure, and transparent payment solutions that support financial inclusion and digital growth.',
      name: 'our_mission_content',
      desc: '',
      args: [],
    );
  }

  /// `Our Vision`
  String get our_vision_title {
    return Intl.message(
      'Our Vision',
      name: 'our_vision_title',
      desc: '',
      args: [],
    );
  }

  /// `We envision a future where digital payments are accessible to everyone, helping communities grow and connect through safe and innovative technology.`
  String get our_vision_content {
    return Intl.message(
      'We envision a future where digital payments are accessible to everyone, helping communities grow and connect through safe and innovative technology.',
      name: 'our_vision_content',
      desc: '',
      args: [],
    );
  }

  /// `Security & Trust`
  String get security_trust_title {
    return Intl.message(
      'Security & Trust',
      name: 'security_trust_title',
      desc: '',
      args: [],
    );
  }

  /// `Security is at the core of Afghan Payment System. We use industry-standard practices to protect user data and ensure secure transactions at all times.`
  String get security_trust_content {
    return Intl.message(
      'Security is at the core of Afghan Payment System. We use industry-standard practices to protect user data and ensure secure transactions at all times.',
      name: 'security_trust_content',
      desc: '',
      args: [],
    );
  }

  /// `Development & Updates`
  String get development_updates_title {
    return Intl.message(
      'Development & Updates',
      name: 'development_updates_title',
      desc: '',
      args: [],
    );
  }

  /// `The app is continuously improved with regular updates to enhance performance, security, and user experience based on feedback.`
  String get development_updates_content {
    return Intl.message(
      'The app is continuously improved with regular updates to enhance performance, security, and user experience based on feedback.',
      name: 'development_updates_content',
      desc: '',
      args: [],
    );
  }

  /// `Secure • Reliable • Simple`
  String get tagline {
    return Intl.message(
      'Secure • Reliable • Simple',
      name: 'tagline',
      desc: '',
      args: [],
    );
  }

  /// `Version 1.0.0`
  String get version_text {
    return Intl.message(
      'Version 1.0.0',
      name: 'version_text',
      desc: '',
      args: [],
    );
  }

  /// `© 2025 Afghan Payment System`
  String get copyright_text {
    return Intl.message(
      '© 2025 Afghan Payment System',
      name: 'copyright_text',
      desc: '',
      args: [],
    );
  }
}

class AppLocalizationDelegate extends LocalizationsDelegate<S> {
  const AppLocalizationDelegate();

  List<Locale> get supportedLocales {
    return const <Locale>[
      Locale.fromSubtags(languageCode: 'en'),
      Locale.fromSubtags(languageCode: 'fa'),
      Locale.fromSubtags(languageCode: 'ps'),
    ];
  }

  @override
  bool isSupported(Locale locale) => _isSupported(locale);
  @override
  Future<S> load(Locale locale) => S.load(locale);
  @override
  bool shouldReload(AppLocalizationDelegate old) => false;

  bool _isSupported(Locale locale) {
    for (var supportedLocale in supportedLocales) {
      if (supportedLocale.languageCode == locale.languageCode) {
        return true;
      }
    }
    return false;
  }
}
