import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/branch_repository.dart';
import '../domain/branch_models.dart';

final branchControllerProvider =
    StateNotifierProvider<BranchController, BranchState>((ref) {
  final repository = ref.watch(branchRepositoryProvider);
  final controller = BranchController(repository: repository);
  controller.bootstrap();
  return controller;
});

class BranchController extends StateNotifier<BranchState> {
  BranchController({required BranchRepository repository})
      : _repository = repository,
        super(const BranchState.initial());

  final BranchRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final branches = await _repository.fetchBranches();
      state = state.copyWith(isLoading: false, branches: branches);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> createBranch(BranchPayload payload) async {
    try {
      final branch = await _repository.createBranch(payload);
      final updated = [...state.branches, branch];
      state = state.copyWith(branches: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateBranch(int id, BranchPayload payload) async {
    try {
      final branch = await _repository.updateBranch(id, payload);
      final updated = state.branches.map((b) => b.id == id ? branch : b).toList();
      state = state.copyWith(branches: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteBranch(int id) async {
    try {
      await _repository.deleteBranch(id);
      final updated = state.branches.where((b) => b.id != id).toList();
      state = state.copyWith(branches: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class BranchState {
  const BranchState({
    required this.isLoading,
    required this.branches,
    required this.errorMessage,
  });

  const BranchState.initial()
      : isLoading = false,
        branches = const [],
        errorMessage = null;

  final bool isLoading;
  final List<BranchDto> branches;
  final String? errorMessage;

  BranchState copyWith({
    bool? isLoading,
    List<BranchDto>? branches,
    String? errorMessage,
  }) {
    return BranchState(
      isLoading: isLoading ?? this.isLoading,
      branches: branches ?? this.branches,
      errorMessage: errorMessage,
    );
  }
}

