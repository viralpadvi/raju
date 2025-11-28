import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/customer_repository.dart';
import '../domain/customer_models.dart';

final customerControllerProvider =
    StateNotifierProvider<CustomerController, CustomerState>((ref) {
  final repository = ref.watch(customerRepositoryProvider);
  final controller = CustomerController(repository: repository);
  controller.bootstrap();
  return controller;
});

class CustomerController extends StateNotifier<CustomerState> {
  CustomerController({required CustomerRepository repository})
      : _repository = repository,
        super(const CustomerState.initial());

  final CustomerRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({String? search, String? status}) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final customers = await _repository.fetchCustomers(
        search: search,
        status: status,
      );
      state = state.copyWith(isLoading: false, customers: customers);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> createCustomer(CustomerPayload payload) async {
    try {
      final customer = await _repository.createCustomer(payload);
      final updated = [...state.customers, customer];
      state = state.copyWith(customers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateCustomer(int id, CustomerPayload payload) async {
    try {
      final customer = await _repository.updateCustomer(id, payload);
      final updated = state.customers.map((c) => c.id == id ? customer : c).toList();
      state = state.copyWith(customers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteCustomer(int id) async {
    try {
      await _repository.deleteCustomer(id);
      final updated = state.customers.where((c) => c.id != id).toList();
      state = state.copyWith(customers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class CustomerState {
  const CustomerState({
    required this.isLoading,
    required this.customers,
    required this.errorMessage,
  });

  const CustomerState.initial()
      : isLoading = false,
        customers = const [],
        errorMessage = null;

  final bool isLoading;
  final List<CustomerDto> customers;
  final String? errorMessage;

  CustomerState copyWith({
    bool? isLoading,
    List<CustomerDto>? customers,
    String? errorMessage,
  }) {
    return CustomerState(
      isLoading: isLoading ?? this.isLoading,
      customers: customers ?? this.customers,
      errorMessage: errorMessage,
    );
  }
}

