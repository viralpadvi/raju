import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/transfer_repository.dart';
import '../domain/transfer_models.dart';

final transferControllerProvider =
    StateNotifierProvider<TransferController, TransferState>((ref) {
  final repository = ref.watch(transferRepositoryProvider);
  final controller = TransferController(repository: repository);
  controller.bootstrap();
  return controller;
});

class TransferController extends StateNotifier<TransferState> {
  TransferController({required TransferRepository repository})
      : _repository = repository,
        super(const TransferState.initial());

  final TransferRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final transfers = await _repository.fetchTransfers();
      state = state.copyWith(isLoading: false, transfers: transfers);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> createTransfer(TransferPayload payload) async {
    try {
      final transfer = await _repository.createTransfer(payload);
      final updated = [...state.transfers, transfer];
      state = state.copyWith(transfers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateTransfer(int id, TransferPayload payload) async {
    try {
      final transfer = await _repository.updateTransfer(id, payload);
      final updated = state.transfers.map((t) => t.id == id ? transfer : t).toList();
      state = state.copyWith(transfers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteTransfer(int id) async {
    try {
      await _repository.deleteTransfer(id);
      final updated = state.transfers.where((t) => t.id != id).toList();
      state = state.copyWith(transfers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> completeTransfer(int id) async {
    try {
      final transfer = await _repository.completeTransfer(id);
      final updated = state.transfers.map((t) => t.id == id ? transfer : t).toList();
      state = state.copyWith(transfers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> cancelTransfer(int id) async {
    try {
      final transfer = await _repository.cancelTransfer(id);
      final updated = state.transfers.map((t) => t.id == id ? transfer : t).toList();
      state = state.copyWith(transfers: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class TransferState {
  const TransferState({
    required this.isLoading,
    required this.transfers,
    required this.errorMessage,
  });

  const TransferState.initial()
      : isLoading = false,
        transfers = const [],
        errorMessage = null;

  final bool isLoading;
  final List<TransferDto> transfers;
  final String? errorMessage;

  TransferState copyWith({
    bool? isLoading,
    List<TransferDto>? transfers,
    String? errorMessage,
  }) {
    return TransferState(
      isLoading: isLoading ?? this.isLoading,
      transfers: transfers ?? this.transfers,
      errorMessage: errorMessage,
    );
  }
}

