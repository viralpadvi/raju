import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/order_repository.dart';
import '../domain/order_models.dart';

final orderControllerProvider =
    StateNotifierProvider<OrderController, OrderState>((ref) {
  final repository = ref.watch(orderRepositoryProvider);
  final controller = OrderController(repository: repository);
  controller.bootstrap();
  return controller;
});

class OrderController extends StateNotifier<OrderState> {
  OrderController({required OrderRepository repository})
      : _repository = repository,
        super(const OrderState.initial());

  final OrderRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({
    int? deliveryAgentId,
    String? status,
    String? search,
    DateTime? dateFrom,
    DateTime? dateTo,
  }) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final orders = await _repository.fetchOrders(
        deliveryAgentId: deliveryAgentId,
        status: status,
        search: search,
        dateFrom: dateFrom,
        dateTo: dateTo,
      );
      state = state.copyWith(isLoading: false, orders: orders);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<OrderDto?> getOrder(int id) async {
    try {
      final order = await _repository.getOrder(id);
      return order;
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
      return null;
    }
  }

  Future<bool> acceptOrder(int id) async {
    try {
      state = state.copyWith(isLoading: true, errorMessage: null);
      final order = await _repository.acceptOrder(id);
      final orders = state.orders.map((o) => o.id == id ? order : o).toList();
      state = state.copyWith(isLoading: false, orders: orders);
      return true;
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
      return false;
    }
  }

  Future<bool> pickupOrder(int id) async {
    try {
      state = state.copyWith(isLoading: true, errorMessage: null);
      final order = await _repository.pickupOrder(id);
      final orders = state.orders.map((o) => o.id == id ? order : o).toList();
      state = state.copyWith(isLoading: false, orders: orders);
      return true;
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
      return false;
    }
  }

  Future<bool> deliverOrder(int id, {String? notes}) async {
    try {
      state = state.copyWith(isLoading: true, errorMessage: null);
      final order = await _repository.deliverOrder(id, notes: notes);
      final orders = state.orders.map((o) => o.id == id ? order : o).toList();
      state = state.copyWith(isLoading: false, orders: orders);
      return true;
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
      return false;
    }
  }

  Future<bool> updateOrderStatus(int id, String status) async {
    try {
      state = state.copyWith(isLoading: true, errorMessage: null);
      final order = await _repository.updateOrderStatus(id, status);
      final orders = state.orders.map((o) => o.id == id ? order : o).toList();
      state = state.copyWith(isLoading: false, orders: orders);
      return true;
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
      return false;
    }
  }
}

class OrderState {
  const OrderState({
    required this.isLoading,
    required this.orders,
    required this.errorMessage,
  });

  const OrderState.initial()
      : isLoading = false,
        orders = const [],
        errorMessage = null;

  final bool isLoading;
  final List<OrderDto> orders;
  final String? errorMessage;

  OrderState copyWith({
    bool? isLoading,
    List<OrderDto>? orders,
    String? errorMessage,
  }) {
    return OrderState(
      isLoading: isLoading ?? this.isLoading,
      orders: orders ?? this.orders,
      errorMessage: errorMessage,
    );
  }
}

