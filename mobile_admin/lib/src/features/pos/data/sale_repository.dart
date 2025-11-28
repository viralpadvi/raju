import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/sale_models.dart';

final saleRepositoryProvider = Provider<SaleRepository>((ref) {
  return SaleRepository(client: ref.watch(apiClientProvider));
});

class SaleRepository {
  SaleRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<SaleDto>> fetchSales({
    String? search,
    int? registerId,
    String? status,
    String? paymentMethod,
    DateTime? dateFrom,
    DateTime? dateTo,
  }) async {
    final queryParams = <String, dynamic>{};
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (registerId != null) {
      queryParams['register_id'] = registerId;
    }
    if (status != null) {
      queryParams['status'] = status;
    }
    if (paymentMethod != null) {
      queryParams['payment_method'] = paymentMethod;
    }
    if (dateFrom != null) {
      queryParams['date_from'] = dateFrom.toIso8601String().split('T')[0];
    }
    if (dateTo != null) {
      queryParams['date_to'] = dateTo.toIso8601String().split('T')[0];
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/pos/sales',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => SaleDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<SaleDto> getSale(int id) async {
    final response = await _client.get<Map<String, dynamic>>(
      '/pos/sales/$id',
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return SaleDto.fromJson(data);
  }
}

