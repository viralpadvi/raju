import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../core/observers/logger_observer.dart';
import '../core/storage/key_value_store.dart';
import '../core/storage/local_database.dart';

class Bootstrap {
  Bootstrap({
    required this.overrides,
    required this.observers,
  });

  final List<Override> overrides;
  final List<ProviderObserver> observers;

  static Future<Bootstrap> create() async {
    final keyValueStore = KeyValueStore();
    await keyValueStore.init();

    final database = await LocalDatabase.initialize();

    return Bootstrap(
      overrides: [
        keyValueStoreProvider.overrideWithValue(keyValueStore),
        localDatabaseProvider.overrideWithValue(database),
      ],
      observers: [AppLoggerObserver()],
    );
  }
}

