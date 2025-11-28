import 'package:dio/dio.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';

final authRepositoryProvider = Provider<AuthRepository>((ref) {
  return AuthRepository(
    unauthenticatedDio: ref.watch(unauthenticatedDioProvider),
  );
});

class AuthRepository {
  AuthRepository({
    required Dio unauthenticatedDio,
  })  : _unauthenticatedDio = unauthenticatedDio;

  final Dio _unauthenticatedDio;

  Future<AuthResponse> login({
    required String email,
    required String password,
    String? deviceName,
  }) async {
    final response = await _unauthenticatedDio.post<Map<String, dynamic>>(
      '/auth/login',
      data: {
        'email': email,
        'password': password,
        'device_name': deviceName ?? 'mobile-admin',
      },
    );

    final data = response.data ?? {};

    return AuthResponse(
      token: data['access_token'] as String? ?? '',
      name: (data['user'] as Map?)?['name'] as String?,
      email: (data['user'] as Map?)?['email'] as String?,
    );
  }

  Future<void> logout({String? token}) async {
    // Use unauthenticatedDio but add token manually if provided
    final headers = <String, dynamic>{};
    if (token != null && token.isNotEmpty) {
      headers['Authorization'] = 'Bearer $token';
    }
    await _unauthenticatedDio.post(
      '/auth/logout',
      options: Options(headers: headers),
    );
  }
}

class AuthResponse {
  AuthResponse({
    required this.token,
    this.name,
    this.email,
  });

  final String token;
  final String? name;
  final String? email;
}

