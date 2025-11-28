import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import 'src/app.dart';
import 'src/bootstrap/bootstrap.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();

  final bootstrap = await Bootstrap.create();

  runApp(
    ProviderScope(
      overrides: bootstrap.overrides,
      observers: bootstrap.observers,
      child: const AdminApp(),
    ),
  );
}

