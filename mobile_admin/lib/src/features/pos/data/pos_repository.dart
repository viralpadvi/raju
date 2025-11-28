import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/cart_models.dart';

final posRepositoryProvider = Provider<PosRepository>((ref) {
  return PosRepository(client: ref.watch(apiClientProvider));
});

class PosRepository {
  PosRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<Map<String, dynamic>> processSale(SalePayload payload) async {
    final response = await _client.post<Map<String, dynamic>>(
      '/pos/sales',
      data: payload.toJson(),
    );
    return response.data ?? {};
  }
}

