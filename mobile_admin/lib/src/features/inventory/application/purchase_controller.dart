import 'dart:convert';

import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/connectivity/connectivity_provider.dart';
import '../../../core/storage/key_value_store.dart';
import '../data/inventory_repository.dart';
import '../domain/purchase_models.dart';

final purchaseControllerProvider =
    StateNotifierProvider<PurchaseController, PurchaseState>((ref) {
  final repository = ref.watch(inventoryRepositoryProvider);
  final cache = ref.watch(keyValueStoreProvider);
  final controller = PurchaseController(repository: repository, store: cache);

  controller.bootstrap(isOnline: ref.read(isOnlineProvider));

  ref.listen<bool>(isOnlineProvider, (previous, next) {
    controller.setOnline(next);
  });

  return controller;
});

class PurchaseController extends StateNotifier<PurchaseState> {
  PurchaseController({
    required InventoryRepository repository,
    required KeyValueStore store,
  })  : _repository = repository,
        _store = store,
        super(const PurchaseState.initial());

  final InventoryRepository _repository;
  final KeyValueStore _store;
  bool _isOnline = false;

  Future<void> bootstrap({required bool isOnline}) async {
    _isOnline = isOnline;
    await _loadCache();
    if (_isOnline) {
      await refresh();
    }
  }

  void setOnline(bool value) {
    if (_isOnline == value) return;
    _isOnline = value;
    if (_isOnline) {
      refresh();
    }
  }

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final purchases = await _repository.fetchPurchases();
      await _store.write(_cacheKey, jsonEncode(purchases.map((p) => p.toJson()).toList()));
      state = state.copyWith(isLoading: false, purchases: purchases);
    } catch (error) {
      state = state.copyWith(isLoading: false, errorMessage: error.toString());
    }
  }

  Future<void> createPurchase(PurchasePayload payload) async {
    if (_isOnline) {
      final purchase = await _repository.createPurchase(payload);
      final updated = [...state.purchases, purchase];
      state = state.copyWith(purchases: updated);
      await _store.write(_cacheKey, jsonEncode(updated.map((p) => p.toJson()).toList()));
      return;
    }

    state = state.copyWith(
      offlineQueue: [
        ...state.offlineQueue,
        payload,
      ],
    );
  }

  Future<void> updatePurchase(int id, PurchasePayload payload) async {
    if (!_isOnline) {
      state = state.copyWith(
        errorMessage: 'Cannot update purchase while offline',
      );
      return;
    }

    try {
      final purchase = await _repository.updatePurchase(id, payload);
      final updated =
          state.purchases.map((p) => p.id == id ? purchase : p).toList();
      state = state.copyWith(purchases: updated);
      await _store.write(_cacheKey, jsonEncode(updated.map((p) => p.toJson()).toList()));
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deletePurchase(int id) async {
    if (!_isOnline) {
      state = state.copyWith(
        errorMessage: 'Cannot delete purchase while offline',
      );
      return;
    }

    try {
      await _repository.deletePurchase(id);
      final updated = state.purchases.where((p) => p.id != id).toList();
      state = state.copyWith(purchases: updated);
      await _store.write(_cacheKey, jsonEncode(updated.map((p) => p.toJson()).toList()));
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> markReceived(int id) async {
    if (!_isOnline) {
      state = state.copyWith(
        errorMessage: 'Cannot mark purchase as received while offline',
      );
      return;
    }

    try {
      final purchase = await _repository.markReceived(id);
      final updated =
          state.purchases.map((p) => p.id == id ? purchase : p).toList();
      state = state.copyWith(purchases: updated);
      await _store.write(_cacheKey, jsonEncode(updated.map((p) => p.toJson()).toList()));
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> cancelPurchase(int id) async {
    if (!_isOnline) {
      state = state.copyWith(
        errorMessage: 'Cannot cancel purchase while offline',
      );
      return;
    }

    try {
      final purchase = await _repository.cancelPurchase(id);
      final updated =
          state.purchases.map((p) => p.id == id ? purchase : p).toList();
      state = state.copyWith(purchases: updated);
      await _store.write(_cacheKey, jsonEncode(updated.map((p) => p.toJson()).toList()));
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> syncOfflineQueue() async {
    if (!_isOnline || state.offlineQueue.isEmpty) return;

    final queue = [...state.offlineQueue];
    for (final payload in queue) {
      try {
        await createPurchase(payload);
        queue.remove(payload);
      } catch (_) {
        break;
      }
    }
    state = state.copyWith(offlineQueue: queue);
  }

  Future<void> _loadCache() async {
    final raw = _store.read<String>(_cacheKey);
    if (raw == null) return;
    final List<dynamic> list = jsonDecode(raw) as List<dynamic>;
    final purchases = list.map((item) => PurchaseDto.fromJson(item as Map<String, dynamic>)).toList();
    state = state.copyWith(purchases: purchases);
  }

  static const _cacheKey = 'inventory::purchases';
}

class PurchaseState {
  const PurchaseState({
    required this.isLoading,
    required this.purchases,
    required this.offlineQueue,
    required this.errorMessage,
  });

  const PurchaseState.initial()
      : isLoading = false,
        purchases = const [],
        offlineQueue = const [],
        errorMessage = null;

  final bool isLoading;
  final List<PurchaseDto> purchases;
  final List<PurchasePayload> offlineQueue;
  final String? errorMessage;

  PurchaseState copyWith({
    bool? isLoading,
    List<PurchaseDto>? purchases,
    List<PurchasePayload>? offlineQueue,
    String? errorMessage,
  }) {
    return PurchaseState(
      isLoading: isLoading ?? this.isLoading,
      purchases: purchases ?? this.purchases,
      offlineQueue: offlineQueue ?? this.offlineQueue,
      errorMessage: errorMessage,
    );
  }
}

