import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:uuid/uuid.dart';

import '../../../core/connectivity/connectivity_provider.dart';
import '../data/pos_repository.dart';
import '../data/sale_queue_store.dart';
import '../domain/cart_models.dart';

final posControllerProvider =
    StateNotifierProvider<PosController, PosState>((ref) {
  final repository = ref.watch(posRepositoryProvider);
  final queueStore = ref.watch(saleQueueStoreProvider);
  final controller = PosController(repository: repository, queueStore: queueStore);

  controller.bootstrap(isOnline: ref.read(isOnlineProvider));

  ref.listen<bool>(isOnlineProvider, (previous, next) {
    controller.setOnline(next);
  });

  return controller;
});

class PosController extends StateNotifier<PosState> {
  PosController({
    required PosRepository repository,
    required SaleQueueStore queueStore,
  })  : _repository = repository,
        _queueStore = queueStore,
        super(const PosState.initial());

  final PosRepository _repository;
  final SaleQueueStore _queueStore;
  final _uuid = const Uuid();
  bool _isOnline = false;

  Future<void> bootstrap({required bool isOnline}) async {
    _isOnline = isOnline;
    final queue = await _queueStore.loadQueue();
    state = state.copyWith(pendingSales: queue);
    if (_isOnline) {
      syncPendingSales();
    }
  }

  void setOnline(bool value) {
    if (_isOnline == value) return;
    _isOnline = value;
    if (_isOnline) {
      syncPendingSales();
    }
  }

  void addItem({required String name, required double price, int quantity = 1}) {
    final item = CartItem(
      id: _uuid.v4(),
      name: name,
      price: price,
      quantity: quantity,
    );

    state = state.copyWith(cartItems: [...state.cartItems, item]);
  }

  void removeItem(String id) {
    state = state.copyWith(
      cartItems: state.cartItems.where((item) => item.id != id).toList(),
    );
  }

  Future<void> checkout({
    int? registerId,
    String? paymentMethod,
    String? notes,
  }) async {
    if (state.cartItems.isEmpty) return;

    final total = state.cartItems.fold(0.0, (sum, item) => sum + item.lineTotal);
    final payload = SalePayload(
      items: state.cartItems,
      total: total,
      registerId: registerId,
      paymentMethod: paymentMethod ?? 'cash',
      notes: notes,
    );

    if (_isOnline) {
      try {
        await _repository.processSale(payload);
        state = state.copyWith(cartItems: [], errorMessage: null);
      } catch (error) {
        state = state.copyWith(errorMessage: error.toString());
        return;
      }
    } else {
      await _queueStore.enqueue(payload);
      final queue = await _queueStore.loadQueue();
      state = state.copyWith(pendingSales: queue);
      state = state.copyWith(cartItems: []);
    }
  }

  void updateItemQuantity(String id, int quantity) {
    if (quantity <= 0) {
      removeItem(id);
      return;
    }
    final updated = state.cartItems.map((item) {
      if (item.id == id) {
        return CartItem(
          id: item.id,
          name: item.name,
          price: item.price,
          quantity: quantity,
        );
      }
      return item;
    }).toList();
    state = state.copyWith(cartItems: updated);
  }

  Future<void> syncPendingSales() async {
    if (!_isOnline) return;
    final queue = await _queueStore.loadQueue();
    for (final item in queue) {
      try {
        await _repository.processSale(item.payload);
        await _queueStore.remove(item.id);
      } catch (_) {
        break;
      }
    }

    final refreshed = await _queueStore.loadQueue();
    state = state.copyWith(pendingSales: refreshed);
  }
}

class PosState {
  const PosState({
    required this.cartItems,
    required this.pendingSales,
    this.errorMessage,
  });

  const PosState.initial()
      : cartItems = const [],
        pendingSales = const [],
        errorMessage = null;

  final List<CartItem> cartItems;
  final List<QueuedSale> pendingSales;
  final String? errorMessage;
  double get total => cartItems.fold(0.0, (sum, item) => sum + item.lineTotal);

  PosState copyWith({
    List<CartItem>? cartItems,
    List<QueuedSale>? pendingSales,
    String? errorMessage,
  }) {
    return PosState(
      cartItems: cartItems ?? this.cartItems,
      pendingSales: pendingSales ?? this.pendingSales,
      errorMessage: errorMessage,
    );
  }
}

