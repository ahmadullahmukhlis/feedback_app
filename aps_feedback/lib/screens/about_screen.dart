import 'package:aps_feedback/generated/l10n.dart';
import 'package:flutter/material.dart';
import 'package:aps_feedback/layouts/main_layout.dart';

class AboutScreen extends StatelessWidget {
  const AboutScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return MainLayout(
      title: S.of(context).app_name,
      subtitle: S.of(context).about,
      currentIndex: 1,
      child: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            _buildHeader(context),
            const SizedBox(height: 16),
            _buildCard(
              context,
              icon: Icons.info_outline,
              title: S.of(context).about_app_title,
              content: S.of(context).about_app_content,
            ),
            _buildCard(
              context,
              icon: Icons.flag_outlined,
              title: S.of(context).our_mission_title,
              content: S.of(context).our_mission_content,
            ),
            _buildCard(
              context,
              icon: Icons.visibility_outlined,
              title: S.of(context).our_vision_title,
              content: S.of(context).our_vision_content,
            ),
            _buildCard(
              context,
              icon: Icons.security_outlined,
              title: S.of(context).security_trust_title,
              content: S.of(context).security_trust_content,
            ),
            _buildCard(
              context,
              icon: Icons.developer_mode_outlined,
              title: S.of(context).development_updates_title,
              content: S.of(context).development_updates_content,
            ),
            const SizedBox(height: 8),
            _buildFooter(context),
          ],
        ),
      ),
    );
  }

  Widget _buildHeader(BuildContext context) {
    final theme = Theme.of(context);
    final isDark = theme.brightness == Brightness.dark;

    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: isDark ? Colors.blueGrey.withOpacity(0.2) : Colors.blue.withOpacity(0.1),
        borderRadius: BorderRadius.circular(20),
      ),
      child: Column(
        children: [
          Image.asset(
            'assets/logo.png',
            width: 80,
            height: 80,
            fit: BoxFit.contain,
            errorBuilder: (context, error, stackTrace) {
              return Icon(
                Icons.image_not_supported,
                size: 80,
                color: isDark ? Colors.white70 : Colors.grey,
              );
            },
          ),
          const SizedBox(height: 1),
          Text(
            S.of(context).app_name,
            style: TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.w700,
              color: theme.colorScheme.onSurface,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 6),
          Text(
            S.of(context).tagline,
            style: TextStyle(
              fontSize: 14,
              color: isDark ? Colors.white70 : Colors.grey,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }

  Widget _buildCard(
      BuildContext context, {
        required IconData icon,
        required String title,
        required String content,
      }) {
    final theme = Theme.of(context);
    final colorScheme = theme.colorScheme;
    final isDark = theme.brightness == Brightness.dark;

    return Container(
      margin: const EdgeInsets.only(bottom: 16),
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: colorScheme.surface,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: isDark
                ? Colors.black.withOpacity(0.3)
                : Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            width: 40,
            height: 40,
            decoration: BoxDecoration(
              color: isDark ? Colors.blue.withOpacity(0.2) : Colors.blue.withOpacity(0.1),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: Colors.blue),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: colorScheme.onSurface,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  content,
                  style: TextStyle(
                    fontSize: 14,
                    height: 1.6,
                    color: isDark ? Colors.white70 : Colors.grey[700],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildFooter(BuildContext context) {
    final theme = Theme.of(context);
    final isDark = theme.brightness == Brightness.dark;

    return Column(
      children: [
        Text(
          S.of(context).version_text,
          style: TextStyle(fontSize: 14, color: isDark ? Colors.white70 : Colors.grey),
        ),
        const SizedBox(height: 6),
        Text(
          S.of(context).copyright_text,
          style: TextStyle(
            fontSize: 12,
            color: isDark ? Colors.white54 : Colors.grey[500],
          ),
        ),
      ],
    );
  }
}
