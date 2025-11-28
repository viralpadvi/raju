import 'dart:convert';

import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/connectivity/connectivity_provider.dart';
import '../../../core/storage/key_value_store.dart';
import '../data/dashboard_repository.dart';
import '../domain/dashboard_models.dart';

final dashboardControllerProvider =
    StateNotifierProvider<DashboardController, DashboardState>((ref) {
  final repository = ref.watch(dashboardRepositoryProvider);
  final store = ref.watch(keyValueStoreProvider);
  final controller = DashboardController(repository: repository, store: store);

  controller.bootstrap(isOnline: ref.read(isOnlineProvider));

  ref.listen<bool>(isOnlineProvider, (previous, next) {
    if (next && next != previous) {
      controller.refresh();
    }
  });

  return controller;
});

class DashboardController extends StateNotifier<DashboardState> {
  DashboardController({
    required DashboardRepository repository,
    required KeyValueStore store,
  })  : _repository = repository,
        _store = store,
        super(const DashboardState.initial());

  final DashboardRepository _repository;
  final KeyValueStore _store;

  Future<void> bootstrap({required bool isOnline}) async {
    await _loadCached();
    if (isOnline) {
      await refresh();
    }
  }

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);

    try {
      final summary = await _repository.fetchSummary();
      final sales = await _repository.fetchRecentSales();
      final lowStock = await _repository.fetchLowStock();

      await _persistCache(summary, sales, lowStock);

      state = state.copyWith(
        isLoading: false,
        summary: summary,
        recentSales: sales,
        lowStock: lowStock,
        lastSyncedAt: DateTime.now(),
      );
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> _loadCached() async {
    final summaryJson = _store.read<String>(_Keys.summary);
    final salesJson = _store.read<String>(_Keys.sales);
    final stockJson = _store.read<String>(_Keys.lowStock);

    if (summaryJson == null && salesJson == null && stockJson == null) {
      return;
    }

    DashboardSummary? summary;
    List<SaleSnapshot> sales = [];
    List<ProductSnapshot> lowStock = [];

    if (summaryJson != null) {
      summary = DashboardSummary.fromJson(jsonDecode(summaryJson) as Map<String, dynamic>);
    }

    if (salesJson != null) {
      final list = (jsonDecode(salesJson) as List<dynamic>).cast<Map<String, dynamic>>();
      sales = list.map(SaleSnapshot.fromJson).toList();
    }

    if (stockJson != null) {
      final list = (jsonDecode(stockJson) as List<dynamic>).cast<Map<String, dynamic>>();
      lowStock = list.map(ProductSnapshot.fromJson).toList();
    }

    state = state.copyWith(
      summary: summary ?? state.summary,
      recentSales: sales.isEmpty ? state.recentSales : sales,
      lowStock: lowStock.isEmpty ? state.lowStock : lowStock,
    );
  }

  Future<void> _persistCache(
    DashboardSummary summary,
    List<SaleSnapshot> sales,
    List<ProductSnapshot> lowStock,
  ) async {
    await _store.write(_Keys.summary, jsonEncode(summary.toJson()));
    await _store.write(_Keys.sales, jsonEncode(sales.map((e) => e.toJson()).toList()));
    await _store.write(_Keys.lowStock, jsonEncode(lowStock.map((e) => e.toJson()).toList()));
  }
}

class DashboardState {
  const DashboardState({
    required this.isLoading,
    required this.summary,
    required this.recentSales,
    required this.lowStock,
    required this.lastSyncedAt,
    required this.errorMessage,
  });

  const DashboardState.initial()
      : isLoading = false,
        summary = null,
        recentSales = const [],
        lowStock = const [],
        lastSyncedAt = null,
        errorMessage = null;

  final bool isLoading;
  final DashboardSummary? summary;
  final List<SaleSnapshot> recentSales;
  final List<ProductSnapshot> lowStock;
  final DateTime? lastSyncedAt;
  final String? errorMessage;

  DashboardState copyWith({
    bool? isLoading,
    DashboardSummary? summary,
    List<SaleSnapshot>? recentSales,
    List<ProductSnapshot>? lowStock,
    DateTime? lastSyncedAt,
    String? errorMessage,
  }) {
    return DashboardState(
      isLoading: isLoading ?? this.isLoading,
      summary: summary ?? this.summary,
      recentSales: recentSales ?? this.recentSales,
      lowStock: lowStock ?? this.lowStock,
      lastSyncedAt: lastSyncedAt ?? this.lastSyncedAt,
      errorMessage: errorMessage,
    );
  }
}

abstract class _Keys {
  static const summary = 'dashboard::summary';
  static const sales = 'dashboard::sales';
  static const lowStock = 'dashboard::low_stock';
}

