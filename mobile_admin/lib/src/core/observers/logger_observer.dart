import 'dart:developer';

import 'package:flutter_riverpod/flutter_riverpod.dart';

class AppLoggerObserver extends ProviderObserver {
  @override
  void didUpdateProvider(
    ProviderBase<Object?> provider,
    Object? previousValue,
    Object? newValue,
    ProviderContainer container,
  ) {
    log(
      'Provider ${provider.name ?? provider.runtimeType} updated.',
      name: 'riverpod',
    );
  }

  @override
  void didAddProvider(ProviderBase<Object?> provider, Object? value, ProviderContainer container) {
    log(
      'Provider ${provider.name ?? provider.runtimeType} added.',
      name: 'riverpod',
    );
  }

  @override
  void didDisposeProvider(ProviderBase<Object?> provider, ProviderContainer container) {
    log(
      'Provider ${provider.name ?? provider.runtimeType} disposed.',
      name: 'riverpod',
    );
  }
}

