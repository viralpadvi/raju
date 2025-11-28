import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/customer_models.dart';

final customerRepositoryProvider = Provider<CustomerRepository>((ref) {
  return CustomerRepository(client: ref.watch(apiClientProvider));
});

class CustomerRepository {
  CustomerRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<CustomerDto>> fetchCustomers({
    String? search,
    String? status,
  }) async {
    final queryParams = <String, dynamic>{};
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (status != null) {
      queryParams['status'] = status;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/admin/users/customers',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => CustomerDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<CustomerDto> createCustomer(CustomerPayload payload) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/admin/users/customers',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return CustomerDto.fromJson(data);
  }

  Future<CustomerDto> updateCustomer(int id, CustomerPayload payload) async {
    final response = await _client.put<Map<String, dynamic>>(
      '/admin/users/customers/$id',
      data: payload.toJson(),
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return CustomerDto.fromJson(data);
  }

  Future<void> deleteCustomer(int id) async {
    await _client.delete('/admin/users/customers/$id');
  }
}

