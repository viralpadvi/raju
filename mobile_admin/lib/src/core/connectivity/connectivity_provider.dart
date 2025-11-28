import 'package:connectivity_plus/connectivity_plus.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

Stream<ConnectivityResult> _connectivityStream() async* {
  final connectivity = Connectivity();
  final initial = await connectivity.checkConnectivity();
  yield _first(initial);
  yield* connectivity.onConnectivityChanged.map(_first);
}

ConnectivityResult _first(List<ConnectivityResult> results) {
  return results.isNotEmpty ? results.first : ConnectivityResult.none;
}

final connectivityStatusProvider = StreamProvider<ConnectivityResult>(
  (ref) => _connectivityStream(),
);

final isOnlineProvider = Provider<bool>((ref) {
  final status = ref.watch(connectivityStatusProvider).value;
  if (status == null) {
    return true; // optimistic default until first event
  }
  return status != ConnectivityResult.none;
});

