import 'package:flutter_riverpod/flutter_riverpod.dart';

final keyValueStoreProvider = Provider<KeyValueStore>((ref) {
  throw UnimplementedError('KeyValueStore has not been bootstrapped.');
});

class KeyValueStore {
  final Map<String, Object?> _memory = {};

  Future<void> init() async {
    // TODO: initialize Hive/SecureStorage once native runtimes are ready.
  }

  Future<void> write(String key, Object? value) async {
    _memory[key] = value;
  }

  T? read<T>(String key, {T? fallback}) {
    final value = _memory[key];
    return value is T ? value : fallback;
  }

  Future<void> delete(String key) async {
    _memory.remove(key);
  }

  Future<void> clear() async {
    _memory.clear();
  }
}

