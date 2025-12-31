
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

final ValueNotifier<ThemeMode> appTheme = ValueNotifier(ThemeMode.system);
final ValueNotifier<Locale> appLocale = ValueNotifier(const Locale('en'));

// Storage instance
final _storage = FlutterSecureStorage();

/// Get TextDirection based on locale
TextDirection getTextDirection(Locale locale) {
  const rtlLanguages = ['fa', 'ar', 'ps']; // Dari, Arabic, Pashto
  return rtlLanguages.contains(locale.languageCode)
      ? TextDirection.rtl
      : TextDirection.ltr;
}

/// Initialize locale from storage (async)
Future<void> initAppLocale() async {
  String? savedLang = await _storage.read(key: 'lang');
  if (savedLang == null || savedLang.isEmpty) {
    savedLang = 'en'; // default to English
  }

  appLocale.value = Locale(savedLang);
}

Future<void> initAppTheme() async {
  final storedTheme = await _storage.read(key: 'theme_code');

  switch (storedTheme) {
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

