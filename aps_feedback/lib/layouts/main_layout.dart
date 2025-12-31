import 'package:aps_feedback/layouts/bottom_widget.dart';
import 'package:aps_feedback/layouts/top_widget.dart';
import 'package:flutter/material.dart';
import 'package:aps_feedback/screens/globals.dart';

class MainLayout extends StatelessWidget {
  final String title;
  final String subtitle;
  final int currentIndex;
  final Widget child;

  const MainLayout({
    super.key,
    required this.title,
    required this.subtitle,
    required this.currentIndex,
    required this.child,
  });

  @override
  Widget build(BuildContext context) {
    return ValueListenableBuilder<Locale>(
      valueListenable: appLocale,
      builder: (context, locale, _) {
        return Directionality(
          textDirection: getTextDirection(locale),
          child: Scaffold(
            // ✅ Use theme-aware background for dark mode
            backgroundColor: Theme.of(context).scaffoldBackgroundColor,
            appBar: TopWidget(title: title, subtitle: subtitle),
            body: SafeArea(
              // ✅ Ensure child has a painted background
              child: ColoredBox(
                color: Theme.of(context).scaffoldBackgroundColor,
                child: child,
              ),
            ),
            bottomNavigationBar: BottomWidget(currentIndex: currentIndex),
          ),
        );
      },
    );
  }
}
