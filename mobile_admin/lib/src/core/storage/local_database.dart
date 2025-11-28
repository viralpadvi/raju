import 'package:flutter_riverpod/flutter_riverpod.dart';

final localDatabaseProvider = Provider<LocalDatabase>((ref) {
  throw UnimplementedError('LocalDatabase not initialized');
});

class LocalDatabase {
  LocalDatabase._();

  static Future<LocalDatabase> initialize() async {
    // TODO: wire up Drift database once schema is finalised.
    return LocalDatabase._();
  }

  Future<void> close() async {
    // placeholder
  }
}

