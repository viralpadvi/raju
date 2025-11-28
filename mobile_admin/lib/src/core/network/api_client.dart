import 'package:dio/dio.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../features/auth/application/auth_controller.dart';
import 'interceptors/auth_interceptor.dart';
import 'interceptors/logging_interceptor.dart';

// Default to localhost Laravel backend on port 8000
// Override with: flutter run --dart-define=API_BASE_URL=http://127.0.0.1:8000/api/admin
const _defaultBase = 'http://127.0.0.1:8000/api/admin';

final baseOptionsProvider = Provider<BaseOptions>((ref) {
  return BaseOptions(
    baseUrl: const String.fromEnvironment('API_BASE_URL', defaultValue: _defaultBase),
    connectTimeout: const Duration(seconds: 10),
    receiveTimeout: const Duration(seconds: 20),
    responseType: ResponseType.json,
  );
});

final unauthenticatedDioProvider = Provider<Dio>((ref) {
  return Dio(ref.watch(baseOptionsProvider));
});

final authenticatedDioProvider = Provider<Dio>((ref) {
  final dio = Dio(ref.watch(baseOptionsProvider));
  dio.interceptors.addAll([
    AuthInterceptor(ref: ref),
    LoggingInterceptor(),
  ]);
  return dio;
});

final apiClientProvider = Provider<ApiClient>((ref) {
  final dio = ref.watch(authenticatedDioProvider);
  return ApiClient(dio);
});

class ApiClient {
  ApiClient(this._dio);

  final Dio _dio;

  Dio get dio => _dio;

  Future<Response<T>> get<T>(
    String path, {
      Map<String, dynamic>? query,
      CancelToken? cancelToken,
    }) {
    return _dio.get<T>(path, queryParameters: query, cancelToken: cancelToken);
  }

  Future<Response<T>> post<T>(
    String path, {
      Object? data,
      Map<String, dynamic>? query,
    }) {
    return _dio.post<T>(path, data: data, queryParameters: query);
  }

  Future<Response<T>> put<T>(
    String path, {
      Object? data,
      Map<String, dynamic>? query,
    }) {
    return _dio.put<T>(path, data: data, queryParameters: query);
  }

  Future<Response<T>> delete<T>(
    String path, {
      Object? data,
      Map<String, dynamic>? query,
    }) {
    return _dio.delete<T>(path, data: data, queryParameters: query);
  }
}

