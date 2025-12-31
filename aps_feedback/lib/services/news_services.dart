import 'package:aps_feedback/config/public_api_calint.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class NewsServices {
  static final _storage = const FlutterSecureStorage();

  static Future<List<Map<String, dynamic>>> getNews() async {
    try {
      // Read language from storage
      final lang = await _storage.read(key: 'lang') ?? 'en'; // fallback to 'en'

      final response = await PublicApiClient.get('news-tables?filters[locale]=$lang');

      final List list = response.data['data'];

      // Adapt response to old model format
      return list.map<Map<String, dynamic>>((item) {
        return {
          'id': item['id'],
          'title': item['title'] ?? '',
          'content': item['description'] ?? '',
          'category': item['category']?['name'] ?? '',
          'isRead': false, // backend does not send it
          'image': item['image']?['url'],
          'created_at': item['createdAt'],
        };
      }).toList();
    } catch (e) {
      print('Error fetching news: $e');
      return [];
    }
  }
}
