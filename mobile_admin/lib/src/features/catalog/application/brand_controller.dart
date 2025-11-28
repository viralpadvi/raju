import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/brand_repository.dart';
import '../domain/brand_models.dart';

final brandControllerProvider =
    StateNotifierProvider<BrandController, BrandState>((ref) {
  final repository = ref.watch(brandRepositoryProvider);
  final controller = BrandController(repository: repository);
  controller.bootstrap();
  return controller;
});

class BrandController extends StateNotifier<BrandState> {
  BrandController({required BrandRepository repository})
      : _repository = repository,
        super(const BrandState.initial());

  final BrandRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final brands = await _repository.fetchBrands();
      state = state.copyWith(isLoading: false, brands: brands);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> createBrand(BrandPayload payload, {XFile? logoFile}) async {
    try {
      final brand = await _repository.createBrand(payload, logoFile: logoFile);
      final updated = [...state.brands, brand];
      state = state.copyWith(brands: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateBrand(int id, BrandPayload payload, {XFile? logoFile}) async {
    try {
      final brand = await _repository.updateBrand(id, payload, logoFile: logoFile);
      final updated = state.brands.map((b) => b.id == id ? brand : b).toList();
      state = state.copyWith(brands: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteBrand(int id) async {
    try {
      await _repository.deleteBrand(id);
      final updated = state.brands.where((b) => b.id != id).toList();
      state = state.copyWith(brands: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class BrandState {
  const BrandState({
    required this.isLoading,
    required this.brands,
    required this.errorMessage,
  });

  const BrandState.initial()
      : isLoading = false,
        brands = const [],
        errorMessage = null;

  final bool isLoading;
  final List<BrandDto> brands;
  final String? errorMessage;

  BrandState copyWith({
    bool? isLoading,
    List<BrandDto>? brands,
    String? errorMessage,
  }) {
    return BrandState(
      isLoading: isLoading ?? this.isLoading,
      brands: brands ?? this.brands,
      errorMessage: errorMessage,
    );
  }
}

