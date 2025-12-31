

import 'package:aps_feedback/screens/home_screen.dart';
import 'package:aps_feedback/screens/login_screen.dart';
import 'package:aps_feedback/screens/our_service_screen.dart';
import 'package:aps_feedback/screens/setting_screen.dart';
import 'package:aps_feedback/screens/support_screen.dart';
import 'package:flutter/material.dart';



class AppRoutes {
  static const home = '/home';
  static const services = '/services';
  static const support = "/support";
  static const login = "/login";
  static const setting = 'setting';
  static Route<dynamic> generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case home:
        return MaterialPageRoute(builder: (_) => const HomeScreen());
      case support :
        return MaterialPageRoute(builder: (_) =>  SupportScreen());
      case services :
        return MaterialPageRoute(builder: (_) =>  OurServicesScreen());
      case login :
        return MaterialPageRoute(builder: (_) =>  LoginScreen());
      case setting :
        return MaterialPageRoute(builder: (_)=> SettingsScreen());

      default:
        return MaterialPageRoute(
          builder: (_) => const Scaffold(
            body: Center(child: Text('Page not found')),
          ),
        );
    }
  }
}