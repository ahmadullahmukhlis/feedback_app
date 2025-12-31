import 'package:aps_feedback/config/public_api_calint.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class OurServices {
  static final _storage = const FlutterSecureStorage();
  static Future<List<Map<String, dynamic>>> getServices() async {

    final lang = await _storage.read(key: 'lang') ?? 'en';
    try {
      final response = await PublicApiClient.get(
          "pages?filters[locale]=$lang&[main_menu][slug][\$eq]=services&populate[blocks][on][blocks.hero-section][populate][image][fields][0]=url"
      );

      final List data = response.data['data'];

      return data.map<Map<String, dynamic>>((item) {
        String? imageUrl;

        // Check if blocks exist and contain hero-section
        if (item['blocks'] != null && item['blocks'].isNotEmpty) {
          final heroBlock = item['blocks'].firstWhere(
                (b) => b['__component'] == 'blocks.hero-section',
            orElse: () => null,
          );
          if (heroBlock != null && heroBlock['image'] != null) {
            imageUrl = heroBlock['image']['url'] as String?;
          }
        }

        return {
          'id': item['id'],
          'title': item['title'] ?? '',
          'description': item['description'] ?? '',
          'slug': item['slug'] ?? '',
          'image': imageUrl ?? '', // empty string if no image
        };
      }).toList();
    } catch (e) {
      print('Error fetching services: $e');
      return [];
    }
  }
}
