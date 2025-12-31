import 'package:aps_feedback/screens/setting_screen.dart';
import 'package:flutter/material.dart';
import 'package:aps_feedback/generated/l10n.dart';

class TopWidget extends StatelessWidget implements PreferredSizeWidget {
  final String title;
  final String subtitle;

  const TopWidget({
    super.key,
    required this.title,
    required this.subtitle,
  });

  bool _shouldShowBackButton(BuildContext context) {
    return ModalRoute.of(context)?.canPop ?? false;
  }

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);

    return AppBar(
      automaticallyImplyLeading: _shouldShowBackButton(context),

      backgroundColor: theme.appBarTheme.backgroundColor ??
          (theme.brightness == Brightness.dark
              ? Colors.grey[900]
              : Colors.blue[800]),

      elevation: 0,

      /// ✅ Direction-safe title (no UI change)
      title: Column(
        mainAxisSize: MainAxisSize.min,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            S.of(context).app_name,
            textAlign: TextAlign.start,
            style: theme.appBarTheme.titleTextStyle ??
                const TextStyle(
                  color: Colors.white,
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                ),
          ),
          if (subtitle.isNotEmpty)
            Text(
              subtitle,
              textAlign: TextAlign.start,
              style: theme.appBarTheme.toolbarTextStyle ??
                  const TextStyle(
                    color: Colors.white70,
                    fontSize: 12,
                  ),
            ),
        ],
      ),

      centerTitle: false,

      /// ✅ ONE place only – Flutter mirrors this automatically
      actions: [
        _settingsButton(context),
      ],
    );
  }

  Widget _settingsButton(BuildContext context) {
    return IconButton(
      icon: const Icon(Icons.settings),
      color: Colors.white,
      onPressed: () {
        Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => const SettingsScreen()),
        );
      },
    );
  }

  @override
  Size get preferredSize => const Size.fromHeight(kToolbarHeight + 10);
}
