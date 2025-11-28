import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/role_models.dart';

final roleRepositoryProvider = Provider<RoleRepository>((ref) {
  return RoleRepository(client: ref.watch(apiClientProvider));
});

class RoleRepository {
  RoleRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<RoleDto>> fetchRoles({String? search}) async {
    final queryParams = <String, dynamic>{};
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/admin/roles',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => RoleDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<RoleDto> createRole(RolePayload payload) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/admin/roles',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return RoleDto.fromJson(data);
  }

  Future<RoleDto> updateRole(int id, RolePayload payload) async {
    final response = await _client.put<Map<String, dynamic>>(
      '/admin/roles/$id',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return RoleDto.fromJson(data);
  }

  Future<void> deleteRole(int id) async {
    await _client.delete('/admin/roles/$id');
  }

  Future<List<PermissionDto>> fetchPermissions() async {
    final response = await _client.get<Map<String, dynamic>>('/admin/permissions');
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => PermissionDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }
}

