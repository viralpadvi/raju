import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../core/widgets/admin_drawer.dart';
import 'sync_coordinator.dart';

class SyncCenterPage extends ConsumerWidget {
  const SyncCenterPage({super.key});

  static const routePath = '/sync';
  static const routeName = 'sync';

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final coordinator = ref.watch(syncCoordinatorProvider);
    final status = coordinator.status();
    final theme = Theme.of(context);

    return Scaffold(
      drawer: AdminDrawer(currentRoute: routePath),
      appBar: AppBar(
        elevation: 0,
        title: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF64748B), Color(0xFF475569)],
                ),
                borderRadius: BorderRadius.circular(8),
              ),
              child: const Icon(Icons.sync_rounded, color: Colors.white, size: 20),
            ),
            const SizedBox(width: 12),
            const Text('Sync Center'),
          ],
        ),
      ),
      body: CustomScrollView(
        slivers: [
          SliverPadding(
            padding: const EdgeInsets.all(16),
            sliver: SliverList(
              delegate: SliverChildListDelegate([
                _StatusTile(
                  label: 'Product drafts',
                  count: status.pendingProductDrafts,
                  icon: Icons.inventory_2_rounded,
                ),
                const SizedBox(height: 12),
                _StatusTile(
                  label: 'Purchase drafts',
                  count: status.pendingPurchaseDrafts,
                  icon: Icons.shopping_cart_rounded,
                ),
                const SizedBox(height: 12),
                _StatusTile(
                  label: 'Offline sales',
                  count: status.pendingSales,
                  icon: Icons.receipt_long_rounded,
                ),
              ]),
            ),
          ),
          SliverPadding(
            padding: const EdgeInsets.all(16),
            sliver: SliverToBoxAdapter(
              child: SizedBox(
                width: double.infinity,
                height: 52,
                child: ElevatedButton.icon(
                  onPressed: coordinator.status().isClean
                      ? null
                      : () async {
                          await coordinator.syncAll();
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(content: Text('Sync triggered')),
                          );
                        },
                  icon: const Icon(Icons.sync_rounded),
                  label: Text(
                    coordinator.status().isClean ? 'All synced' : 'Sync now',
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  style: ElevatedButton.styleFrom(
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                  ),
                ),
              ),
            ),
          ),
          const SliverPadding(padding: EdgeInsets.only(bottom: 16)),
        ],
      ),
    );
  }
}

class _StatusTile extends StatelessWidget {
  const _StatusTile({
    required this.label,
    required this.count,
    required this.icon,
  });

  final String label;
  final int count;
  final IconData icon;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    final isClean = count == 0;
    
    return Container(
      decoration: BoxDecoration(
        color: theme.colorScheme.surfaceContainerHighest.withOpacity(0.3),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: theme.colorScheme.outline.withOpacity(0.1),
        ),
      ),
      child: ListTile(
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        leading: Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: isClean
                ? const Color(0xFF10B981).withOpacity(0.1)
                : const Color(0xFFF59E0B).withOpacity(0.1),
            borderRadius: BorderRadius.circular(12),
          ),
          child: Icon(
            icon,
            color: isClean ? const Color(0xFF10B981) : const Color(0xFFF59E0B),
            size: 20,
          ),
        ),
        title: Text(
          label,
          style: theme.textTheme.titleMedium?.copyWith(
            fontWeight: FontWeight.w600,
          ),
        ),
        trailing: Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
          decoration: BoxDecoration(
            color: isClean
                ? const Color(0xFF10B981).withOpacity(0.2)
                : const Color(0xFFF59E0B).withOpacity(0.2),
            borderRadius: BorderRadius.circular(20),
          ),
          child: Text(
            count.toString(),
            style: theme.textTheme.titleSmall?.copyWith(
              color: isClean ? const Color(0xFF10B981) : const Color(0xFFF59E0B),
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
      ),
    );
  }
}

