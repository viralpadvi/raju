class SyncStatus {
  const SyncStatus({
    required this.pendingProductDrafts,
    required this.pendingPurchaseDrafts,
    required this.pendingSales,
  });

  final int pendingProductDrafts;
  final int pendingPurchaseDrafts;
  final int pendingSales;

  bool get isClean =>
      pendingProductDrafts == 0 && pendingPurchaseDrafts == 0 && pendingSales == 0;
}

