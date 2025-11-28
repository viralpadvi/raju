import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/storage/key_value_store.dart';
import '../data/auth_repository.dart';

final authControllerProvider =
    StateNotifierProvider<AuthController, AuthState>((ref) {
  final repository = ref.watch(authRepositoryProvider);
  final store = ref.watch(keyValueStoreProvider);
  return AuthController(repository: repository, store: store);
});

class AuthController extends StateNotifier<AuthState> {
  AuthController({
    required AuthRepository repository,
    required KeyValueStore store,
  })  : _repository = repository,
        _store = store,
        super(const AuthState.unauthenticated()) {
    final token = _store.read<String>('token');
    final displayName = _store.read<String>('display_name');
    if (token != null && token.isNotEmpty) {
      state = AuthState.authenticated(token: token, displayName: displayName);
    }
  }

  final AuthRepository _repository;
  final KeyValueStore _store;

  Future<void> login(String email, String password) async {
    state = state.copyWith(isLoading: true, errorMessage: null);

    try {
      final response = await _repository.login(email: email, password: password);
      await _store.write('token', response.token);

      await _store.write('display_name', response.name ?? email);

      state = AuthState.authenticated(
        token: response.token,
        displayName: response.name ?? email,
        isOfflineSession: false,
      );
    } catch (error) {
      final cachedToken = _store.read<String>('token');
      final cachedName = _store.read<String>('display_name');

      if (cachedToken != null && cachedToken.isNotEmpty) {
        state = AuthState.authenticated(
          token: cachedToken,
          displayName: cachedName,
          isOfflineSession: true,
        ).copyWith(errorMessage: 'Offline mode enabled. ${_getErrorMessage(error)}');
        return;
      }

      state = state.copyWith(
        isLoading: false,
        errorMessage: _getErrorMessage(error),
      );
    }
  }

  String _getErrorMessage(dynamic error) {
    final errorStr = error.toString();
    
    if (errorStr.contains('connection error') || 
        errorStr.contains('XMLHttpRequest')) {
      return 'Cannot connect to server. Please ensure:\n'
          '1. Laravel backend is running\n'
          '2. API URL is correct (check api_client.dart)\n'
          '3. CORS is configured in Laravel';
    }
    if (errorStr.contains('401') || errorStr.contains('Unauthorized')) {
      return 'Invalid email or password';
    }
    if (errorStr.contains('403') || errorStr.contains('Forbidden')) {
      return 'Access denied. Admin privileges required.';
    }
    if (errorStr.contains('500') || errorStr.contains('Server error')) {
      return 'Server error. Please check:\n'
          '1. Laravel logs (storage/logs/laravel.log)\n'
          '2. Database connection\n'
          '3. Environment configuration (.env file)';
    }
    if (errorStr.contains('timeout')) {
      return 'Connection timeout. Please check your network and server.';
    }
    // Remove technical details for user-friendly message
    return errorStr
        .replaceAll('DioException [bad response]: ', '')
        .replaceAll('DioException [connection error]: ', '')
        .split('\n')
        .first; // Show only first line
  }

  Future<void> logout() async {
    final token = state.token;
    await _repository.logout(token: token);
    await _store.delete('token');
    await _store.delete('display_name');
    state = const AuthState.unauthenticated();
  }

  void forceLogout() {
    state = const AuthState.unauthenticated();
  }

  void forceOfflineSession(String token) {
    state = AuthState.authenticated(
      token: token,
      displayName: state.displayName,
      isOfflineSession: true,
    );
  }

  String? get token => state.token;
}

class AuthState {
  const AuthState({
    required this.isAuthenticated,
    required this.isLoading,
    required this.isOfflineSession,
    this.token,
    this.displayName,
    this.errorMessage,
  });

  const AuthState.unauthenticated()
      : isAuthenticated = false,
        isLoading = false,
        isOfflineSession = false,
        token = null,
        displayName = null,
        errorMessage = null;

  const AuthState.authenticated({
    required String token,
    String? displayName,
    bool isOfflineSession = false,
  })
      : isAuthenticated = true,
        isLoading = false,
        isOfflineSession = isOfflineSession,
        token = token,
        displayName = displayName,
        errorMessage = null;

  final bool isAuthenticated;
  final bool isLoading;
  final bool isOfflineSession;
  final String? token;
  final String? displayName;
  final String? errorMessage;

  AuthState copyWith({
    bool? isAuthenticated,
    bool? isLoading,
    bool? isOfflineSession,
    String? token,
    String? displayName,
    String? errorMessage,
  }) {
    return AuthState(
      isAuthenticated: isAuthenticated ?? this.isAuthenticated,
      isLoading: isLoading ?? this.isLoading,
      isOfflineSession: isOfflineSession ?? this.isOfflineSession,
      token: token ?? this.token,
      displayName: displayName ?? this.displayName,
      errorMessage: errorMessage ?? this.errorMessage,
    );
  }

  bool get hasCachedSession => token != null && token!.isNotEmpty;
}

