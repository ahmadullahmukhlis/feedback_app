import 'package:aps_feedback/generated/l10n.dart';
import 'package:aps_feedback/models/ourservice.dart';
import 'package:aps_feedback/screens/our_service_details_screen.dart';
import 'package:aps_feedback/services/our_services.dart';
import 'package:flutter/material.dart';
import 'package:aps_feedback/layouts/main_layout.dart';

class OurServicesScreen extends StatefulWidget {
  const OurServicesScreen({super.key});

  @override
  State<OurServicesScreen> createState() => _OurServicesScreenState();
}

class _OurServicesScreenState extends State<OurServicesScreen> {
  List<OurserviceModel> services = [];
  bool isLoading = true;
  Locale? _currentLocale;

  @override
  void initState() {
    super.initState();
    _loadServices();
  }
  @override
  void didChangeDependencies() {
    super.didChangeDependencies();

    final locale = Localizations.localeOf(context);
    if (_currentLocale != locale) {
      _currentLocale = locale;
      _loadServices(); // reload news when language changes
    }
  }

  Future<void> _loadServices() async {
    try {
      final List<Map<String, dynamic>> response =
      await OurServices.getServices();

      setState(() {
        services =
            response.map((e) => OurserviceModel.fromJson(e)).toList();
        isLoading = false;
      });
    } catch (e) {
      print('Error loading services: $e');
      setState(() => isLoading = false);
    }
  }

  // 🔄 Refresh indicator handler (NO UI CHANGE)
  Future<void> _onRefresh() async {
    await _loadServices();
  }

  Widget _buildServiceCard(OurserviceModel service) {
    final title = service.title;
    final description = service.description;
    final imageUrl = service.image;

    return InkWell(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (_) =>
                OurServiceDetailScreen(service: service.toJson()),
          ),
        );
      },
      child: Card(
        margin: const EdgeInsets.symmetric(vertical: 8, horizontal: 16),
        elevation: 2,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            if (imageUrl != null && imageUrl.isNotEmpty)
              ClipRRect(
                borderRadius:
                const BorderRadius.vertical(top: Radius.circular(12)),
                child: Image.network(
                  imageUrl,
                  height: 180,
                  width: double.infinity,
                  fit: BoxFit.cover,
                  errorBuilder: (_, __, ___) =>
                      Container(height: 180, color: Colors.grey[300]),
                ),
              ),
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(title,
                      style: const TextStyle(
                          fontSize: 18, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 8),
                  Text(description,
                      style: const TextStyle(
                          fontSize: 14, color: Colors.grey)),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return MainLayout(
      title: "Afghan Payment System",
      subtitle: S.of(context).services,
      currentIndex: 2,
      child: isLoading
          ? const Center(child: CircularProgressIndicator())
          : services.isEmpty
          ? Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children:  [
         const   Icon(Icons.work_outline,
                size: 64, color: Colors.grey),
         const   SizedBox(height: 12),
            Text(S.of(context).no_services_available,
                style:
                TextStyle(color: Colors.grey, fontSize: 16)),
          ],
        ),
      )
          : RefreshIndicator(
        onRefresh: _onRefresh,
        child: ListView.builder(
          physics: const AlwaysScrollableScrollPhysics(),
          itemCount: services.length,
          itemBuilder: (context, index) =>
              _buildServiceCard(services[index]),
        ),
      ),
    );
  }
}
