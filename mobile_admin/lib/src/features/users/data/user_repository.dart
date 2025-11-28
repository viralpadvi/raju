import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/user_models.dart';

final userRepositoryProvider = Provider<UserRepository>((ref) {
  return UserRepository(client: ref.watch(apiClientProvider));
});

class UserRepository {
  UserRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<UserDto>> fetchUsers({
    String? search,
    String? role,
    String? status,
  }) async {
    final queryParams = <String, dynamic>{};
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (role != null) {
      queryParams['role'] = role;
    }
    if (status != null) {
      queryParams['status'] = status;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/admin/users',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => UserDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<UserDto> createUser(UserPayload payload) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/admin/users',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return UserDto.fromJson(data);
  }

  Future<UserDto> updateUser(int id, UserPayload payload) async {
    final response = await _client.put<Map<String, dynamic>>(
      '/admin/users/$id',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return UserDto.fromJson(data);
  }

  Future<void> deleteUser(int id) async {
    await _client.delete('/admin/users/$id');
  }
}

