import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/branch_models.dart';

final branchRepositoryProvider = Provider<BranchRepository>((ref) {
  return BranchRepository(client: ref.watch(apiClientProvider));
});

class BranchRepository {
  BranchRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<BranchDto>> fetchBranches({String? search, bool? status}) async {
    final queryParams = <String, dynamic>{};
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (status != null) {
      queryParams['status'] = status;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/inventory/branches',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => BranchDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<BranchDto> createBranch(BranchPayload payload) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/inventory/branches',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return BranchDto.fromJson(data);
  }

  Future<BranchDto> updateBranch(int id, BranchPayload payload) async {
    final response = await _client.put<Map<String, dynamic>>(
      '/inventory/branches/$id',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return BranchDto.fromJson(data);
  }

  Future<void> deleteBranch(int id) async {
    await _client.delete('/inventory/branches/$id');
  }
}

