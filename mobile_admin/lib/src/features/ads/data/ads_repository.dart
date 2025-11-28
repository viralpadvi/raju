import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/ads_models.dart';

final adsRepositoryProvider = Provider<AdsRepository>((ref) {
  return AdsRepository(client: ref.watch(apiClientProvider));
});

class AdsRepository {
  AdsRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<AdCampaignDto>> fetchCampaigns() async {
    final response = await _client.get<Map<String, dynamic>>('/advertising/campaigns');
    final list = response.data?['data'] as List<dynamic>? ?? [];
    return list.map((item) => AdCampaignDto.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<List<AdPlacementDto>> fetchPlacements() async {
    final response = await _client.get<Map<String, dynamic>>('/advertising/placements');
    final list = response.data?['data'] as List<dynamic>? ?? [];
    return list.map((item) => AdPlacementDto.fromJson(item as Map<String, dynamic>)).toList();
  }
}

