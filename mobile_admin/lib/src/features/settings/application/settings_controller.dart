import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/settings_repository.dart';
import '../domain/setting_models.dart';

final settingsControllerProvider =
    StateNotifierProvider<SettingsController, SettingsState>((ref) {
  final repository = ref.watch(settingsRepositoryProvider);
  final controller = SettingsController(repository: repository);
  controller.refresh();
  return controller;
});

class SettingsController extends StateNotifier<SettingsState> {
  SettingsController({required SettingsRepository repository})
      : _repository = repository,
        super(const SettingsState.initial());

  final SettingsRepository _repository;

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final settings = await _repository.fetchSettings();
      state = state.copyWith(isLoading: false, settings: settings);
    } catch (error) {
      state = state.copyWith(isLoading: false, errorMessage: error.toString());
    }
  }

  Future<void> saveGeneral({
    required String storeName,
    required String storeEmail,
    required String storePhone,
  }) async {
    await _repository.update({
      'store_name': storeName,
      'store_email': storeEmail,
      'store_phone': storePhone,
    });
    refresh();
  }

  Future<void> runMaintenance(String action) async {
    await _repository.runMaintenance(action);
  }
}

class SettingsState {
  const SettingsState({
    required this.isLoading,
    required this.settings,
    required this.errorMessage,
  });

  const SettingsState.initial()
      : isLoading = false,
        settings = const [],
        errorMessage = null;

  final bool isLoading;
  final List<SettingDto> settings;
  final String? errorMessage;

  SettingsState copyWith({
    bool? isLoading,
    List<SettingDto>? settings,
    String? errorMessage,
  }) {
    return SettingsState(
      isLoading: isLoading ?? this.isLoading,
      settings: settings ?? this.settings,
      errorMessage: errorMessage,
    );
  }
}

