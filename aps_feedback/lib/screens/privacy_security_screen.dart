import 'package:flutter/material.dart';
import 'package:aps_feedback/layouts/main_layout.dart';
import 'package:aps_feedback/generated/l10n.dart';

class PrivacySecurityScreen extends StatelessWidget {
  const PrivacySecurityScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return MainLayout(
      title: 'Afghan Payment System',
      subtitle: S.of(context).privacy_security_title,
      currentIndex: 1,
      child: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Container(
          padding: const EdgeInsets.all(20),
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(16),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.05),
                blurRadius: 10,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _SectionTitle(S.of(context).privacy_security_title),
              _SectionText(S.of(context).privacy_security_text),

              _SectionTitle(S.of(context).information_we_collect_title),
              _SectionText(S.of(context).information_we_collect_text),

              _SectionTitle(S.of(context).how_we_use_info_title),
              _SectionText(S.of(context).how_we_use_info_text),

              _SectionTitle(S.of(context).data_storage_title),
              _SectionText(S.of(context).data_storage_text),

              _SectionTitle(S.of(context).network_api_title),
              _SectionText(S.of(context).network_api_text),

              _SectionTitle(S.of(context).user_control_title),
              _SectionText(S.of(context).user_control_text),

              _SectionTitle(S.of(context).third_party_title),
              _SectionText(S.of(context).third_party_text),

              _SectionTitle(S.of(context).updates_support_title),
              _SectionText(S.of(context).updates_support_text),
            ],
          ),
        ),
      ),
    );
  }
}

class _SectionTitle extends StatelessWidget {
  final String text;
  const _SectionTitle(this.text);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8, top: 16),
      child: Text(
        text,
        style: const TextStyle(
          fontSize: 18,
          fontWeight: FontWeight.w700,
        ),
      ),
    );
  }
}

class _SectionText extends StatelessWidget {
  final String text;
  const _SectionText(this.text);

  @override
  Widget build(BuildContext context) {
    return Text(
      text,
      style: const TextStyle(
        fontSize: 14,
        height: 1.6,
      ),
    );
  }
}
