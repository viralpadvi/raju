import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import '../../../core/widgets/admin_drawer.dart';
import '../../ads/presentation/ads_page.dart';
import '../../catalog/presentation/catalog_page.dart';
import '../../dashboard/presentation/dashboard_page.dart';
import '../../inventory/presentation/inventory_page.dart';
import '../../pos/presentation/pos_page.dart';
import '../../reports/presentation/reports_page.dart';
import '../../settings/presentation/settings_page.dart';
import '../../../sync/sync_center_page.dart';

class MenuPage extends StatelessWidget {
  const MenuPage({super.key});

  static const routePath = '/menu';
  static const routeName = 'menu';

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);

    final menuItems = [
      _MenuItem(
        title: 'Dashboard',
        icon: Icons.dashboard_rounded,
        route: DashboardPage.routePath,
        gradient: [const Color(0xFF6366F1), const Color(0xFF8B5CF6)],
        description: 'Overview & Analytics',
      ),
      _MenuItem(
        title: 'Catalog',
        icon: Icons.inventory_2_rounded,
        route: CatalogPage.routePath,
        gradient: [const Color(0xFF10B981), const Color(0xFF059669)],
        description: 'Product Management',
      ),
      _MenuItem(
        title: 'Inventory',
        icon: Icons.warehouse_rounded,
        route: InventoryPage.routePath,
        gradient: [const Color(0xFFF59E0B), const Color(0xFFD97706)],
        description: 'Purchase Orders',
      ),
      _MenuItem(
        title: 'POS Terminal',
        icon: Icons.point_of_sale_rounded,
        route: PosPage.routePath,
        gradient: [const Color(0xFFEF4444), const Color(0xFFDC2626)],
        description: 'Point of Sale',
      ),
      _MenuItem(
        title: 'Ad Campaigns',
        icon: Icons.campaign_rounded,
        route: AdsPage.routePath,
        gradient: [const Color(0xFFEC4899), const Color(0xFFDB2777)],
        description: 'Advertising',
      ),
      _MenuItem(
        title: 'Reports',
        icon: Icons.analytics_rounded,
        route: ReportsPage.routePath,
        gradient: [const Color(0xFF06B6D4), const Color(0xFF0891B2)],
        description: 'Analytics & Exports',
      ),
      _MenuItem(
        title: 'Sync Center',
        icon: Icons.sync_rounded,
        route: SyncCenterPage.routePath,
        gradient: [const Color(0xFF64748B), const Color(0xFF475569)],
        description: 'Data Synchronization',
      ),
      _MenuItem(
        title: 'Settings',
        icon: Icons.settings_rounded,
        route: SettingsPage.routePath,
        gradient: [const Color(0xFF6B7280), const Color(0xFF4B5563)],
        description: 'App Configuration',
      ),
    ];

    return Scaffold(
      drawer: AdminDrawer(currentRoute: routePath),
      appBar: AppBar(
        elevation: 0,
        title: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  colors: [
                    theme.colorScheme.primary,
                    theme.colorScheme.secondary,
                  ],
                ),
                borderRadius: BorderRadius.circular(8),
              ),
              child: const Icon(Icons.apps_rounded, color: Colors.white, size: 20),
            ),
            const SizedBox(width: 12),
            const Text('Menu'),
          ],
        ),
      ),
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [
              theme.colorScheme.primaryContainer.withOpacity(0.1),
              theme.colorScheme.surface,
            ],
          ),
        ),
        child: CustomScrollView(
          slivers: [
            SliverPadding(
              padding: const EdgeInsets.fromLTRB(16, 24, 16, 8),
              sliver: SliverToBoxAdapter(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Quick Access',
                      style: theme.textTheme.headlineSmall?.copyWith(
                        fontWeight: FontWeight.bold,
                        color: theme.colorScheme.onSurface,
                      ),
                    ),
                    const SizedBox(height: 8),
                    Text(
                      'Navigate to any section of the admin panel',
                      style: theme.textTheme.bodyMedium?.copyWith(
                        color: theme.colorScheme.onSurfaceVariant,
                      ),
                    ),
                  ],
                ),
              ),
            ),
            SliverPadding(
              padding: const EdgeInsets.all(16),
              sliver: SliverGrid(
                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 2,
                  crossAxisSpacing: 16,
                  mainAxisSpacing: 16,
                  childAspectRatio: 1.1,
                ),
                delegate: SliverChildBuilderDelegate(
                  (context, index) {
                    final item = menuItems[index];
                    return _MenuCard(
                      item: item,
                      onTap: () => context.go(item.route),
                    );
                  },
                  childCount: menuItems.length,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _MenuItem {
  const _MenuItem({
    required this.title,
    required this.icon,
    required this.route,
    required this.gradient,
    required this.description,
  });

  final String title;
  final IconData icon;
  final String route;
  final List<Color> gradient;
  final String description;
}

class _MenuCard extends StatelessWidget {
  const _MenuCard({
    required this.item,
    required this.onTap,
  });

  final _MenuItem item;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    final isDark = theme.brightness == Brightness.dark;

    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(20),
        child: Container(
          decoration: BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
              colors: isDark
                  ? [
                      item.gradient[0].withOpacity(0.2),
                      item.gradient[1].withOpacity(0.15),
                    ]
                  : [
                      item.gradient[0].withOpacity(0.1),
                      item.gradient[1].withOpacity(0.05),
                    ],
            ),
            borderRadius: BorderRadius.circular(20),
            border: Border.all(
              color: item.gradient[0].withOpacity(0.3),
              width: 1.5,
            ),
            boxShadow: [
              BoxShadow(
                color: item.gradient[0].withOpacity(0.1),
                blurRadius: 10,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    gradient: LinearGradient(
                      colors: item.gradient,
                    ),
                    borderRadius: BorderRadius.circular(16),
                    boxShadow: [
                      BoxShadow(
                        color: item.gradient[0].withOpacity(0.4),
                        blurRadius: 12,
                        offset: const Offset(0, 6),
                      ),
                    ],
                  ),
                  child: Icon(
                    item.icon,
                    color: Colors.white,
                    size: 32,
                  ),
                ),
                const SizedBox(height: 16),
                Text(
                  item.title,
                  style: theme.textTheme.titleMedium?.copyWith(
                    fontWeight: FontWeight.bold,
                    color: item.gradient[0],
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 4),
                Text(
                  item.description,
                  style: theme.textTheme.bodySmall?.copyWith(
                    color: theme.colorScheme.onSurfaceVariant,
                    fontSize: 11,
                  ),
                  textAlign: TextAlign.center,
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

