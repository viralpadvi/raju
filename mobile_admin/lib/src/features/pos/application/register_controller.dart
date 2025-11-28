import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/register_repository.dart';
import '../domain/register_models.dart';

final registerControllerProvider =
    StateNotifierProvider<RegisterController, RegisterState>((ref) {
  final repository = ref.watch(registerRepositoryProvider);
  final controller = RegisterController(repository: repository);
  controller.bootstrap();
  return controller;
});

class RegisterController extends StateNotifier<RegisterState> {
  RegisterController({required RegisterRepository repository})
      : _repository = repository,
        super(const RegisterState.initial());

  final RegisterRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({int? branchId, bool? status}) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final registers = await _repository.fetchRegisters(
        branchId: branchId,
        status: status,
      );
      state = state.copyWith(isLoading: false, registers: registers);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> createRegister(RegisterPayload payload) async {
    try {
      final register = await _repository.createRegister(payload);
      final updated = [...state.registers, register];
      state = state.copyWith(registers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateRegister(int id, RegisterPayload payload) async {
    try {
      final register = await _repository.updateRegister(id, payload);
      final updated = state.registers.map((r) => r.id == id ? register : r).toList();
      state = state.copyWith(registers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteRegister(int id) async {
    try {
      await _repository.deleteRegister(id);
      final updated = state.registers.where((r) => r.id != id).toList();
      state = state.copyWith(registers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class RegisterState {
  const RegisterState({
    required this.isLoading,
    required this.registers,
    required this.errorMessage,
  });

  const RegisterState.initial()
      : isLoading = false,
        registers = const [],
        errorMessage = null;

  final bool isLoading;
  final List<RegisterDto> registers;
  final String? errorMessage;

  RegisterState copyWith({
    bool? isLoading,
    List<RegisterDto>? registers,
    String? errorMessage,
  }) {
    return RegisterState(
      isLoading: isLoading ?? this.isLoading,
      registers: registers ?? this.registers,
      errorMessage: errorMessage,
    );
  }
}

