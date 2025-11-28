import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/setting_models.dart';

final settingRepositoryProvider = Provider<SettingRepository>((ref) {
  return SettingRepository(client: ref.watch(apiClientProvider));
});

class SettingRepository {
  SettingRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<SettingDto>> fetchSettings() async {
    final response = await _client.get<dynamic>('/settings');
    List<dynamic> data;
    
    // Handle both direct array response and wrapped response
    if (response.data is List) {
      data = response.data as List<dynamic>;
    } else if (response.data is Map && (response.data as Map).containsKey('data')) {
      data = (response.data as Map<String, dynamic>)['data'] as List<dynamic>? ?? [];
    } else {
      data = [];
    }
    
    return data
        .map((item) => SettingDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<void> updateSettings(SettingsPayload payload) async {
    await _client.put('/settings', data: payload.toJson());
  }

  Future<void> createBackup() async {
    await _client.post('/settings/backup');
  }

  Future<void> clearCache() async {
    await _client.post('/settings/clear-cache');
  }

  Future<void> updateSystem() async {
    await _client.post('/settings/update-system');
  }

  Future<void> resetSettings() async {
    await _client.post('/settings/reset');
  }
}

