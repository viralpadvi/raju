import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/transfer_models.dart';

// Note: This repository is ready but requires the backend API to be implemented first
// Expected API endpoints:
// GET    /inventory/transfers - List all transfers
// POST   /inventory/transfers - Create new transfer
// GET    /inventory/transfers/{id} - Get transfer details
// PUT    /inventory/transfers/{id} - Update transfer
// DELETE /inventory/transfers/{id} - Delete transfer
// POST   /inventory/transfers/{id}/complete - Complete transfer
// POST   /inventory/transfers/{id}/cancel - Cancel transfer

final transferRepositoryProvider = Provider<TransferRepository>((ref) {
  return TransferRepository(client: ref.watch(apiClientProvider));
});

class TransferRepository {
  TransferRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<TransferDto>> fetchTransfers({
    String? search,
    String? status,
    int? fromBranchId,
    int? toBranchId,
  }) async {
    // TODO: Uncomment when API is ready
    // final queryParams = <String, dynamic>{};
    // if (search != null && search.isNotEmpty) {
    //   queryParams['search'] = search;
    // }
    // if (status != null) {
    //   queryParams['status'] = status;
    // }
    // if (fromBranchId != null) {
    //   queryParams['from_branch_id'] = fromBranchId;
    // }
    // if (toBranchId != null) {
    //   queryParams['to_branch_id'] = toBranchId;
    // }
    //
    // final response = await _client.get<Map<String, dynamic>>(
    //   '/inventory/transfers',
    //   queryParameters: queryParams,
    // );
    // final data = response.data?['data'] as List<dynamic>? ?? [];
    // return data
    //     .map((item) => TransferDto.fromJson(item as Map<String, dynamic>))
    //     .toList();
    
    // Placeholder - returns empty list until API is ready
    return [];
  }

  Future<TransferDto> createTransfer(TransferPayload payload) async {
    // TODO: Uncomment when API is ready
    // final response = await _client.post<Map<String, dynamic>>(
    //   '/inventory/transfers',
    //   data: payload.toJson(),
    // );
    // final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    // return TransferDto.fromJson(data);
    
    // Placeholder - throws error until API is ready
    throw Exception('Transfer API not yet implemented. Please create the backend API first.');
  }

  Future<TransferDto> updateTransfer(int id, TransferPayload payload) async {
    // TODO: Uncomment when API is ready
    // final response = await _client.put<Map<String, dynamic>>(
    //   '/inventory/transfers/$id',
    //   data: payload.toJson(),
    // );
    // final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    // return TransferDto.fromJson(data);
    
    throw Exception('Transfer API not yet implemented.');
  }

  Future<void> deleteTransfer(int id) async {
    // TODO: Uncomment when API is ready
    // await _client.delete('/inventory/transfers/$id');
    
    throw Exception('Transfer API not yet implemented.');
  }

  Future<TransferDto> completeTransfer(int id) async {
    // TODO: Uncomment when API is ready
    // final response = await _client.post<Map<String, dynamic>>(
    //   '/inventory/transfers/$id/complete',
    // );
    // final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    // return TransferDto.fromJson(data);
    
    throw Exception('Transfer API not yet implemented.');
  }

  Future<TransferDto> cancelTransfer(int id) async {
    // TODO: Uncomment when API is ready
    // final response = await _client.post<Map<String, dynamic>>(
    //   '/inventory/transfers/$id/cancel',
    // );
    // final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    // return TransferDto.fromJson(data);
    
    throw Exception('Transfer API not yet implemented.');
  }
}

