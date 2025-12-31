import 'package:aps_feedback/routes/app_routes.dart';
import 'package:flutter/material.dart';
import 'package:aps_feedback/screens/globals.dart';
import 'package:aps_feedback/generated/l10n.dart';

class BottomWidget extends StatelessWidget {
  final int currentIndex;

  const BottomWidget({super.key, required this.currentIndex});

  @override
  Widget build(BuildContext context) {
    final isRtl = Directionality.of(context) == TextDirection.rtl;

    return BottomNavigationBar(
      type: BottomNavigationBarType.fixed,
      currentIndex: currentIndex,
      selectedItemColor: Colors.blue[800],
      unselectedItemColor: Colors.grey[600],
      selectedLabelStyle: const TextStyle(fontSize: 12),
      unselectedLabelStyle: const TextStyle(fontSize: 12),
      onTap: (index) {
        if (currentIndex == index) return;
        String targetRoute;
        switch (index) {
          case 0:
            targetRoute = AppRoutes.home;
            break;
          case 1:
            targetRoute = AppRoutes.support;
            break;
          case 2:
            targetRoute = AppRoutes.services;
            break;
          default:
            targetRoute = AppRoutes.home;
        }

        if (ModalRoute.of(context)?.settings.name != targetRoute) {
          Navigator.pushNamedAndRemoveUntil(context, targetRoute, (route) => false);
        }
      },
      items: [
        BottomNavigationBarItem(icon: const Icon(Icons.home), label: S.of(context).home),
        BottomNavigationBarItem(
          icon: Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(color: Colors.blue[800], shape: BoxShape.circle),
            child: const Icon(Icons.send, color: Colors.white, size: 20),
          ),
          label: S.of(context).support,
        ),
        BottomNavigationBarItem(icon: const Icon(Icons.home_repair_service), label: S.of(context).services),
      ],
    );
  }
}