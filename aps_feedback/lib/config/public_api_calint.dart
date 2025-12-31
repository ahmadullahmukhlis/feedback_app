import 'package:dio/dio.dart';

class PublicApiClient {
  static final Dio _dio = Dio(
    BaseOptions(
      baseUrl: 'http://test.aps.gov.af:1337/api/',
      connectTimeout: const Duration(seconds: 10),
      receiveTimeout: const Duration(seconds: 10),
      headers: {
        'Content-Type': 'application/json',
      },
    ),
  )..interceptors.add(
    LogInterceptor(
      requestBody: true,
      responseBody: true,
    ),
  );

  /// GET (PUBLIC – no token)
  static Future<Response> get(
      String path, {
        Map<String, dynamic>? query,
      }) async {
    return await _dio.get(
      path,
      queryParameters: query,
      options: Options(
        headers: {}, // 🔥 ENSURE NO AUTH HEADER
      ),
    );
  }

  /// POST (PUBLIC – no token)
  static Future<Response> post(
      String path,
      Map<String, dynamic> data,
      ) async {
    return await _dio.post(
      path,
      data: data,
      options: Options(
        headers: {}, // 🔥 ENSURE NO AUTH HEADER
      ),
    );
  }
}
