import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/ads_repository.dart';
import '../domain/ads_models.dart';

final adsControllerProvider = StateNotifierProvider<AdsController, AdsState>((ref) {
  final repository = ref.watch(adsRepositoryProvider);
  final controller = AdsController(repository: repository);
  controller.refresh();
  return controller;
});

class AdsController extends StateNotifier<AdsState> {
  AdsController({required AdsRepository repository})
      : _repository = repository,
        super(const AdsState.initial());

  final AdsRepository _repository;

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final campaigns = await _repository.fetchCampaigns();
      final placements = await _repository.fetchPlacements();
      state = state.copyWith(
        isLoading: false,
        campaigns: campaigns,
        placements: placements,
      );
    } catch (error) {
      state = state.copyWith(isLoading: false, errorMessage: error.toString());
    }
  }
}

class AdsState {
  const AdsState({
    required this.isLoading,
    required this.campaigns,
    required this.placements,
    required this.errorMessage,
  });

  const AdsState.initial()
      : isLoading = false,
        campaigns = const [],
        placements = const [],
        errorMessage = null;

  final bool isLoading;
  final List<AdCampaignDto> campaigns;
  final List<AdPlacementDto> placements;
  final String? errorMessage;

  AdsState copyWith({
    bool? isLoading,
    List<AdCampaignDto>? campaigns,
    List<AdPlacementDto>? placements,
    String? errorMessage,
  }) {
    return AdsState(
      isLoading: isLoading ?? this.isLoading,
      campaigns: campaigns ?? this.campaigns,
      placements: placements ?? this.placements,
      errorMessage: errorMessage,
    );
  }
}

