import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/purchase_models.dart';
import '../domain/branch_models.dart';

final inventoryRepositoryProvider = Provider<InventoryRepository>((ref) {
  return InventoryRepository(client: ref.watch(apiClientProvider));
});

class InventoryRepository {
  InventoryRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<PurchaseDto>> fetchPurchases() async {
    final response = await _client.get<Map<String, dynamic>>('/inventory/purchases');
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data.map((item) => PurchaseDto.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<PurchaseDto> createPurchase(PurchasePayload payload) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/inventory/purchases',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return PurchaseDto.fromJson(data);
  }

  Future<PurchaseDto> updatePurchase(int id, PurchasePayload payload) async {
    final response = await _client.put<Map<String, dynamic>>(
      '/inventory/purchases/$id',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return PurchaseDto.fromJson(data);
  }

  Future<void> deletePurchase(int id) async {
    await _client.delete('/inventory/purchases/$id');
  }

  Future<PurchaseDto> markReceived(int id) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/inventory/purchases/$id/receive',
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return PurchaseDto.fromJson(data);
  }

  Future<PurchaseDto> cancelPurchase(int id) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/inventory/purchases/$id/cancel',
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return PurchaseDto.fromJson(data);
  }
}

final supplierRepositoryProvider = Provider<SupplierRepository>((ref) {
  return SupplierRepository(client: ref.watch(apiClientProvider));
});

class SupplierRepository {
  SupplierRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<SupplierDto>> fetchSuppliers({bool? activeOnly}) async {
    final queryParams = <String, dynamic>{};
    if (activeOnly != null) {
      queryParams['status'] = activeOnly;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/inventory/suppliers',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => SupplierDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }
}

class SupplierDto {
  SupplierDto({required this.id, required this.name});

  factory SupplierDto.fromJson(Map<String, dynamic> json) {
    return SupplierDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
    );
  }

  final int id;
  final String name;
}


