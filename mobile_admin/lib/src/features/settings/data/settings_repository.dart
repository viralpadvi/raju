import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/setting_models.dart';

final settingsRepositoryProvider = Provider<SettingsRepository>((ref) {
  return SettingsRepository(client: ref.watch(apiClientProvider));
});

class SettingsRepository {
  SettingsRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<SettingDto>> fetchSettings() async {
    final response = await _client.get<List<dynamic>>('/settings');
    final data = response.data ?? [];
    return data.map((item) => SettingDto.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<void> update(Map<String, dynamic> payload) {
    return _client.put('/settings', data: payload);
  }

  Future<void> runMaintenance(String action) {
    switch (action) {
      case 'backup':
        return _client.post('/settings/backup');
      case 'clear-cache':
        return _client.post('/settings/clear-cache');
      case 'reset':
        return _client.post('/settings/reset');
      case 'update-system':
        return _client.post('/settings/update-system');
      default:
        throw UnsupportedError('Unknown action');
    }
  }
}

