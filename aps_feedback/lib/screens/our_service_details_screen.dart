import 'package:aps_feedback/layouts/main_layout.dart';
import 'package:flutter/material.dart';

class OurServiceDetailScreen extends StatelessWidget {
  final Map<String, dynamic> service;

  const OurServiceDetailScreen({super.key, required this.service});

  @override
  Widget build(BuildContext context) {
    final double imageHeight = MediaQuery.of(context).size.height * 0.28;

    return MainLayout(
      title: "Afghan Payment System",
      subtitle: service['title'] ?? '',
      currentIndex: 2,
      child: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Image
            if (service['image'] != null &&
                service['image'].toString().isNotEmpty)
              ClipRRect(
                borderRadius: BorderRadius.circular(12),
                child: Image.network(
                  service['image'],
                  width: double.infinity,
                  height: imageHeight,
                  fit: BoxFit.cover,
                  errorBuilder: (_, __, ___) => Container(
                    height: imageHeight,
                    alignment: Alignment.center,
                    color: Colors.grey[300],
                    child: const Icon(
                      Icons.image_not_supported,
                      size: 40,
                      color: Colors.grey,
                    ),
                  ),
                ),
              ),

            if (service['image'] != null &&
                service['image'].toString().isNotEmpty)
              const SizedBox(height: 16),

            // Title
            Text(
              service['title'] ?? '',
              style: const TextStyle(
                fontSize: 22,
                fontWeight: FontWeight.bold,
              ),
            ),

            const SizedBox(height: 20),

            // Description (CKEditor content)
            Text(
              service['description'] ?? '',
              style: const TextStyle(
                fontSize: 16,
                height: 1.6,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
