import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/order_models.dart';

final orderRepositoryProvider = Provider<OrderRepository>((ref) {
  return OrderRepository(client: ref.watch(apiClientProvider));
});

class OrderRepository {
  OrderRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<OrderDto>> fetchOrders({
    int? deliveryAgentId,
    String? status,
    String? search,
    DateTime? dateFrom,
    DateTime? dateTo,
  }) async {
    final queryParams = <String, dynamic>{};
    if (deliveryAgentId != null) {
      queryParams['delivery_agent_id'] = deliveryAgentId;
    }
    if (status != null && status.isNotEmpty) {
      queryParams['status'] = status;
    }
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (dateFrom != null) {
      queryParams['date_from'] = dateFrom.toIso8601String().split('T')[0];
    }
    if (dateTo != null) {
      queryParams['date_to'] = dateTo.toIso8601String().split('T')[0];
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/delivery/orders',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => OrderDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<OrderDto> getOrder(int id) async {
    final response = await _client.get<Map<String, dynamic>>(
      '/delivery/orders/$id',
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return OrderDto.fromJson(data);
  }

  Future<OrderDto> updateOrderStatus(int id, String status) async {
    final response = await _client.put<Map<String, dynamic>>(
      '/delivery/orders/$id/status',
      data: {'status': status},
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return OrderDto.fromJson(data);
  }

  Future<OrderDto> acceptOrder(int id) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/delivery/orders/$id/accept',
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return OrderDto.fromJson(data);
  }

  Future<OrderDto> pickupOrder(int id) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/delivery/orders/$id/pickup',
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return OrderDto.fromJson(data);
  }

  Future<OrderDto> deliverOrder(int id, {String? notes}) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/delivery/orders/$id/deliver',
      data: notes != null ? {'notes': notes} : null,
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return OrderDto.fromJson(data);
  }
}

