import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/setting_repository.dart';
import '../domain/setting_models.dart';

final settingControllerProvider =
    StateNotifierProvider<SettingController, SettingState>((ref) {
  final repository = ref.watch(settingRepositoryProvider);
  final controller = SettingController(repository: repository);
  controller.bootstrap();
  return controller;
});

class SettingController extends StateNotifier<SettingState> {
  SettingController({required SettingRepository repository})
      : _repository = repository,
        super(const SettingState.initial());

  final SettingRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null, successMessage: null);
    try {
      final settings = await _repository.fetchSettings();
      state = state.copyWith(isLoading: false, settings: settings);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> updateSettings(SettingsPayload payload) async {
    state = state.copyWith(errorMessage: null, successMessage: null);
    try {
      await _repository.updateSettings(payload);
      await refresh();
      state = state.copyWith(successMessage: 'Settings updated successfully');
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> createBackup() async {
    try {
      await _repository.createBackup();
      state = state.copyWith(successMessage: 'Backup created successfully');
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> clearCache() async {
    try {
      await _repository.clearCache();
      state = state.copyWith(successMessage: 'Cache cleared successfully');
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateSystem() async {
    try {
      await _repository.updateSystem();
      state = state.copyWith(successMessage: 'System updated successfully');
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> resetSettings() async {
    try {
      await _repository.resetSettings();
      await refresh();
      state = state.copyWith(successMessage: 'Settings reset to defaults');
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class SettingState {
  const SettingState({
    required this.isLoading,
    required this.settings,
    required this.errorMessage,
    this.successMessage,
  });

  const SettingState.initial()
      : isLoading = false,
        settings = const [],
        errorMessage = null,
        successMessage = null;

  final bool isLoading;
  final List<SettingDto> settings;
  final String? errorMessage;
  final String? successMessage;

  SettingDto? getSetting(String key) {
    try {
      return settings.firstWhere((s) => s.key == key);
    } catch (_) {
      return null;
    }
  }

  String? getSettingValue(String key) {
    final setting = getSetting(key);
    return setting?.value?.toString();
  }

  SettingState copyWith({
    bool? isLoading,
    List<SettingDto>? settings,
    String? errorMessage,
    String? successMessage,
  }) {
    return SettingState(
      isLoading: isLoading ?? this.isLoading,
      settings: settings ?? this.settings,
      errorMessage: errorMessage,
      successMessage: successMessage,
    );
  }
}

