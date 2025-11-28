import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/sale_repository.dart';
import '../domain/sale_models.dart';

final saleControllerProvider =
    StateNotifierProvider<SaleController, SaleState>((ref) {
  final repository = ref.watch(saleRepositoryProvider);
  final controller = SaleController(repository: repository);
  controller.bootstrap();
  return controller;
});

class SaleController extends StateNotifier<SaleState> {
  SaleController({required SaleRepository repository})
      : _repository = repository,
        super(const SaleState.initial());

  final SaleRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({
    String? search,
    int? registerId,
    String? status,
    String? paymentMethod,
    DateTime? dateFrom,
    DateTime? dateTo,
  }) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final sales = await _repository.fetchSales(
        search: search,
        registerId: registerId,
        status: status,
        paymentMethod: paymentMethod,
        dateFrom: dateFrom,
        dateTo: dateTo,
      );
      state = state.copyWith(isLoading: false, sales: sales);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<SaleDto?> getSale(int id) async {
    try {
      final sale = await _repository.getSale(id);
      return sale;
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
      return null;
    }
  }
}

class SaleState {
  const SaleState({
    required this.isLoading,
    required this.sales,
    required this.errorMessage,
  });

  const SaleState.initial()
      : isLoading = false,
        sales = const [],
        errorMessage = null;

  final bool isLoading;
  final List<SaleDto> sales;
  final String? errorMessage;

  SaleState copyWith({
    bool? isLoading,
    List<SaleDto>? sales,
    String? errorMessage,
  }) {
    return SaleState(
      isLoading: isLoading ?? this.isLoading,
      sales: sales ?? this.sales,
      errorMessage: errorMessage,
    );
  }
}

