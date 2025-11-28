import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/shift_repository.dart';
import '../domain/shift_models.dart';

final shiftControllerProvider =
    StateNotifierProvider<ShiftController, ShiftState>((ref) {
  final repository = ref.watch(shiftRepositoryProvider);
  final controller = ShiftController(repository: repository);
  controller.bootstrap();
  return controller;
});

class ShiftController extends StateNotifier<ShiftState> {
  ShiftController({required ShiftRepository repository})
      : _repository = repository,
        super(const ShiftState.initial());

  final ShiftRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({
    int? registerId,
    String? status,
    DateTime? dateFrom,
    DateTime? dateTo,
  }) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final shifts = await _repository.fetchShifts(
        registerId: registerId,
        status: status,
        dateFrom: dateFrom,
        dateTo: dateTo,
      );
      state = state.copyWith(isLoading: false, shifts: shifts);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> startShift(ShiftPayload payload) async {
    try {
      final shift = await _repository.startShift(payload);
      final updated = [...state.shifts, shift];
      state = state.copyWith(shifts: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> closeShift(int id, {double? endingCash, String? notes}) async {
    try {
      final shift = await _repository.closeShift(id, endingCash: endingCash, notes: notes);
      final updated = state.shifts.map((s) => s.id == id ? shift : s).toList();
      state = state.copyWith(shifts: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateShift(int id, {double? endingCash, String? notes}) async {
    try {
      final shift = await _repository.updateShift(id, endingCash: endingCash, notes: notes);
      final updated = state.shifts.map((s) => s.id == id ? shift : s).toList();
      state = state.copyWith(shifts: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteShift(int id) async {
    try {
      await _repository.deleteShift(id);
      final updated = state.shifts.where((s) => s.id != id).toList();
      state = state.copyWith(shifts: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class ShiftState {
  const ShiftState({
    required this.isLoading,
    required this.shifts,
    required this.errorMessage,
  });

  const ShiftState.initial()
      : isLoading = false,
        shifts = const [],
        errorMessage = null;

  final bool isLoading;
  final List<ShiftDto> shifts;
  final String? errorMessage;

  ShiftState copyWith({
    bool? isLoading,
    List<ShiftDto>? shifts,
    String? errorMessage,
  }) {
    return ShiftState(
      isLoading: isLoading ?? this.isLoading,
      shifts: shifts ?? this.shifts,
      errorMessage: errorMessage,
    );
  }
}

