import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/user_repository.dart';
import '../domain/user_models.dart';

final userControllerProvider =
    StateNotifierProvider<UserController, UserState>((ref) {
  final repository = ref.watch(userRepositoryProvider);
  final controller = UserController(repository: repository);
  controller.bootstrap();
  return controller;
});

class UserController extends StateNotifier<UserState> {
  UserController({required UserRepository repository})
      : _repository = repository,
        super(const UserState.initial());

  final UserRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({String? search, String? role, String? status}) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final users = await _repository.fetchUsers(
        search: search,
        role: role,
        status: status,
      );
      state = state.copyWith(isLoading: false, users: users);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> createUser(UserPayload payload) async {
    try {
      final user = await _repository.createUser(payload);
      final updated = [...state.users, user];
      state = state.copyWith(users: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateUser(int id, UserPayload payload) async {
    try {
      final user = await _repository.updateUser(id, payload);
      final updated = state.users.map((u) => u.id == id ? user : u).toList();
      state = state.copyWith(users: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteUser(int id) async {
    try {
      await _repository.deleteUser(id);
      final updated = state.users.where((u) => u.id != id).toList();
      state = state.copyWith(users: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class UserState {
  const UserState({
    required this.isLoading,
    required this.users,
    required this.errorMessage,
  });

  const UserState.initial()
      : isLoading = false,
        users = const [],
        errorMessage = null;

  final bool isLoading;
  final List<UserDto> users;
  final String? errorMessage;

  UserState copyWith({
    bool? isLoading,
    List<UserDto>? users,
    String? errorMessage,
  }) {
    return UserState(
      isLoading: isLoading ?? this.isLoading,
      users: users ?? this.users,
      errorMessage: errorMessage,
    );
  }
}

