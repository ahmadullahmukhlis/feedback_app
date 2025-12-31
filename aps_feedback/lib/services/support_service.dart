import 'dart:io';
import 'package:aps_feedback/config/api_client.dart';
import 'package:dio/dio.dart';

class SupportService {
  /// Get support messages
  static Future<List<Map<String, dynamic>>> get(page,limit) async {
    try {
      final response = await ApiClient.get('messages?page=$page&&limit=$limit');

        return List<Map<String, dynamic>>.from(response.data);

    } on DioError catch (e) {
      print('Dio error fetching messages: ${e.response?.data ?? e.message}');
      return [];
    } catch (e) {
      print('Unexpected error fetching messages: $e');
      return [];
    }
  }

  /// Post a support message with optional image
  static Future<bool> post({required String message, File? image}) async {
    try {
      FormData formData = FormData.fromMap({
        'message': message,
        if (image != null)
          'image': await MultipartFile.fromFile(
            image.path,
            filename: image.path.split('/').last,
          ),
      });

      final response = await ApiClient.post(
        'send',
        formData,
      );
      print(response);
      return response.statusCode == 200 || response.statusCode == 201;
    } on DioError catch (e) {
      print('Dio error sending support message: ${e.response?.data ?? e.message}');
      return false;
    } catch (e) {
      print('Unexpected error sending support message: $e');
      return false;
    }
  }
}
