import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class ApiClient {
  static final Dio _dio = Dio(
    BaseOptions(
      baseUrl: 'http://10.60.76.77:8000/api/',
      connectTimeout: const Duration(seconds: 10),
      receiveTimeout: const Duration(seconds: 10),
      headers: {
        'Content-Type': 'application/json', // default
      },
    ),
  )..interceptors.add(
    LogInterceptor(responseBody: true, requestBody: true),
  );

  static final _storage = const FlutterSecureStorage();

  // Automatically add token from storage
  static Future<void> _addToken() async {
    final token = await _storage.read(key: 'auth_token');
    if (token != null) {
      _dio.options.headers['Authorization'] = 'Bearer $token';
    }
  }

  // GET request
  static Future<Response> get(String path, {Map<String, dynamic>? query}) async {
    await _addToken();
    return await _dio.get(path, queryParameters: query);
  }

  // POST request (accepts Map<String, dynamic> for JSON or FormData for files)
  static Future<Response> post(
      String path,
      dynamic data, // can be Map<String, dynamic> or FormData
      ) async {
    await _addToken();

    Options options;

    if (data is FormData) {
      // If sending FormData (with file), set proper content type
      options = Options(contentType: 'multipart/form-data');
    } else {
      // JSON data
      options = Options(contentType: 'application/json');
    }

    return await _dio.post(
      path,
      data: data,
      options: options,
    );
  }
}
