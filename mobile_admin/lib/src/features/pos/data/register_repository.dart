import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/register_models.dart';

final registerRepositoryProvider = Provider<RegisterRepository>((ref) {
  return RegisterRepository(client: ref.watch(apiClientProvider));
});

class RegisterRepository {
  RegisterRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<RegisterDto>> fetchRegisters({
    int? branchId,
    bool? status,
  }) async {
    final queryParams = <String, dynamic>{};
    if (branchId != null) {
      queryParams['branch_id'] = branchId;
    }
    if (status != null) {
      queryParams['status'] = status;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/inventory/registers',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => RegisterDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<RegisterDto> createRegister(RegisterPayload payload) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/inventory/registers',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return RegisterDto.fromJson(data);
  }

  Future<RegisterDto> updateRegister(int id, RegisterPayload payload) async {
    final response = await _client.put<Map<String, dynamic>>(
      '/inventory/registers/$id',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return RegisterDto.fromJson(data);
  }

  Future<void> deleteRegister(int id) async {
    await _client.delete('/inventory/registers/$id');
  }
}

