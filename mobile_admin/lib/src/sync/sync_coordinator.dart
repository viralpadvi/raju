import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../features/catalog/application/product_controller.dart';
import '../features/inventory/application/purchase_controller.dart';
import '../features/pos/application/pos_controller.dart';
import 'sync_status.dart';

final syncCoordinatorProvider = Provider<SyncCoordinator>((ref) {
  return SyncCoordinator(ref);
});

class SyncCoordinator {
  SyncCoordinator(this._ref);

  final Ref _ref;

  SyncStatus status() {
    final productState = _ref.read(productControllerProvider);
    final purchaseState = _ref.read(purchaseControllerProvider);
    final posState = _ref.read(posControllerProvider);

    return SyncStatus(
      pendingProductDrafts: productState.drafts.length,
      pendingPurchaseDrafts: purchaseState.offlineQueue.length,
      pendingSales: posState.pendingSales.length,
    );
  }

  Future<void> syncAll() async {
    await Future.wait([
      _ref.read(productControllerProvider.notifier).syncDrafts(),
      _ref.read(purchaseControllerProvider.notifier).syncOfflineQueue(),
      _ref.read(posControllerProvider.notifier).syncPendingSales(),
    ]);
  }
}

