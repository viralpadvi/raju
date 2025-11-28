import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/dashboard_models.dart';

final dashboardRepositoryProvider = Provider<DashboardRepository>((ref) {
  return DashboardRepository(client: ref.watch(apiClientProvider));
});

class DashboardRepository {
  DashboardRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<DashboardSummary> fetchSummary() async {
    final response = await _client.get<Map<String, dynamic>>('/dashboard/summary');
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return DashboardSummary.fromJson(data);
  }

  Future<List<SaleSnapshot>> fetchRecentSales({int limit = 5}) async {
    final response = await _client.get<Map<String, dynamic>>(
      '/dashboard/recent-sales',
      query: {'limit': limit},
    );
    final list = response.data?['data'] as List<dynamic>? ?? [];
    return list.map((item) => SaleSnapshot.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<List<ProductSnapshot>> fetchLowStock({int limit = 5}) async {
    final response = await _client.get<Map<String, dynamic>>(
      '/dashboard/low-stock',
      query: {'limit': limit},
    );
    final list = response.data?['data'] as List<dynamic>? ?? [];
    return list.map((item) => ProductSnapshot.fromJson(item as Map<String, dynamic>)).toList();
  }
}

