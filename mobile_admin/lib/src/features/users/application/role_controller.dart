import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/role_repository.dart';
import '../domain/role_models.dart';

final roleControllerProvider =
    StateNotifierProvider<RoleController, RoleState>((ref) {
  final repository = ref.watch(roleRepositoryProvider);
  final controller = RoleController(repository: repository);
  controller.bootstrap();
  return controller;
});

class RoleController extends StateNotifier<RoleState> {
  RoleController({required RoleRepository repository})
      : _repository = repository,
        super(const RoleState.initial());

  final RoleRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
    await fetchPermissions();
  }

  Future<void> refresh({String? search}) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final roles = await _repository.fetchRoles(search: search);
      state = state.copyWith(isLoading: false, roles: roles);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> fetchPermissions() async {
    try {
      final permissions = await _repository.fetchPermissions();
      state = state.copyWith(permissions: permissions);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> createRole(RolePayload payload) async {
    try {
      final role = await _repository.createRole(payload);
      final updated = [...state.roles, role];
      state = state.copyWith(roles: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> updateRole(int id, RolePayload payload) async {
    try {
      final role = await _repository.updateRole(id, payload);
      final updated = state.roles.map((r) => r.id == id ? role : r).toList();
      state = state.copyWith(roles: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteRole(int id) async {
    try {
      await _repository.deleteRole(id);
      final updated = state.roles.where((r) => r.id != id).toList();
      state = state.copyWith(roles: updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }
}

class RoleState {
  const RoleState({
    required this.isLoading,
    required this.roles,
    required this.permissions,
    required this.errorMessage,
  });

  const RoleState.initial()
      : isLoading = false,
        roles = const [],
        permissions = const [],
        errorMessage = null;

  final bool isLoading;
  final List<RoleDto> roles;
  final List<PermissionDto> permissions;
  final String? errorMessage;

  RoleState copyWith({
    bool? isLoading,
    List<RoleDto>? roles,
    List<PermissionDto>? permissions,
    String? errorMessage,
  }) {
    return RoleState(
      isLoading: isLoading ?? this.isLoading,
      roles: roles ?? this.roles,
      permissions: permissions ?? this.permissions,
      errorMessage: errorMessage,
    );
  }
}

