import 'dart:developer';

import 'package:dio/dio.dart';

class LoggingInterceptor extends Interceptor {
  @override
  void onRequest(RequestOptions options, RequestInterceptorHandler handler) {
    log('➡️ ${options.method} ${options.uri}', name: 'api');
    if (options.data != null) {
      log('payload: ${options.data}', name: 'api');
    }
    handler.next(options);
  }

  @override
  void onResponse(Response response, ResponseInterceptorHandler handler) {
    log('✅ ${response.statusCode} ${response.requestOptions.uri}', name: 'api');
    handler.next(response);
  }

  @override
  void onError(DioException err, ErrorInterceptorHandler handler) {
    log('❌ ${err.response?.statusCode} ${err.requestOptions.uri} ${err.message}', name: 'api');
    handler.next(err);
  }
}

