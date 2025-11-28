import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';

import '../../features/ads/presentation/ads_page.dart';
import '../../features/auth/application/auth_controller.dart';
import '../../features/auth/presentation/login_page.dart';
import '../../features/catalog/presentation/brands_page.dart';
import '../../features/catalog/presentation/categories_page.dart';
import '../../features/catalog/presentation/catalog_page.dart';
import '../../features/inventory/presentation/branches_page.dart';
import '../../features/inventory/presentation/transfers_page.dart';
import '../../features/pos/presentation/registers_page.dart';
import '../../features/pos/presentation/sales_history_page.dart';
import '../../features/pos/presentation/shifts_page.dart';
import '../../features/users/presentation/customers_page.dart';
import '../../features/users/presentation/users_page.dart';
import '../../features/users/presentation/roles_page.dart';
import '../../features/dashboard/presentation/dashboard_page.dart';
import '../../features/inventory/presentation/inventory_page.dart';
import '../../features/menu/presentation/menu_page.dart';
import '../../features/pos/presentation/pos_page.dart';
import '../../features/reports/presentation/reports_page.dart';
import '../../features/settings/presentation/settings_page.dart';
import '../../sync/sync_center_page.dart';

class AdminDrawer extends ConsumerWidget {
  const AdminDrawer({super.key, required this.currentRoute});

  final String currentRoute;

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final theme = Theme.of(context);
    final isDark = theme.brightness == Brightness.dark;

    return Drawer(
      child: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: isDark
                ? [
                    theme.colorScheme.primaryContainer,
                    theme.colorScheme.surface,
                  ]
                : [
                    theme.colorScheme.primaryContainer.withOpacity(0.3),
                    theme.colorScheme.surface,
                  ],
          ),
        ),
        child: Column(
          children: [
            DrawerHeader(
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                  colors: [
                    theme.colorScheme.primary,
                    theme.colorScheme.primary.withOpacity(0.7),
                  ],
                ),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  Container(
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Icon(
                      Icons.admin_panel_settings,
                      size: 32,
                      color: Colors.white,
                    ),
                  ),
                  const SizedBox(height: 12),
                  Text(
                    'Admin Console',
                    style: theme.textTheme.titleLarge?.copyWith(
                      color: Colors.white,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  Text(
                    'Commerce Management',
                    style: theme.textTheme.bodySmall?.copyWith(
                      color: Colors.white.withOpacity(0.9),
                    ),
                  ),
                ],
              ),
            ),
            Expanded(
              child: ListView(
                padding: EdgeInsets.zero,
                children: [
                  _DrawerTile(
                    icon: Icons.apps_rounded,
                    title: 'Menu',
                    route: MenuPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF6366F1),
                      const Color(0xFF8B5CF6),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.dashboard_rounded,
                    title: 'Dashboard',
                    route: DashboardPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF6366F1),
                      const Color(0xFF8B5CF6),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.inventory_2_rounded,
                    title: 'Products',
                    route: CatalogPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF10B981),
                      const Color(0xFF059669),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.category_rounded,
                    title: 'Categories',
                    route: CategoriesPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF10B981),
                      const Color(0xFF059669),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.label_rounded,
                    title: 'Brands',
                    route: BrandsPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF10B981),
                      const Color(0xFF059669),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.warehouse_rounded,
                    title: 'Purchases',
                    route: InventoryPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFFF59E0B),
                      const Color(0xFFD97706),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.business_rounded,
                    title: 'Branches',
                    route: BranchesPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF8B5CF6),
                      const Color(0xFF7C3AED),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.swap_horiz_rounded,
                    title: 'Transfers',
                    route: TransfersPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF06B6D4),
                      const Color(0xFF0891B2),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.point_of_sale_rounded,
                    title: 'POS Terminal',
                    route: PosPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFFEF4444),
                      const Color(0xFFDC2626),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.point_of_sale_rounded,
                    title: 'Registers',
                    route: RegistersPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFFEF4444),
                      const Color(0xFFDC2626),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.schedule_rounded,
                    title: 'Shifts',
                    route: ShiftsPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF3B82F6),
                      const Color(0xFF2563EB),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.history_rounded,
                    title: 'Sales History',
                    route: SalesHistoryPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFFEF4444),
                      const Color(0xFFDC2626),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.campaign_rounded,
                    title: 'Ad Campaigns',
                    route: AdsPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFFEC4899),
                      const Color(0xFFDB2777),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.analytics_rounded,
                    title: 'Reports',
                    route: ReportsPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF06B6D4),
                      const Color(0xFF0891B2),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.people_rounded,
                    title: 'Customers',
                    route: CustomersPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF8B5CF6),
                      const Color(0xFF6366F1),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.person_rounded,
                    title: 'Users',
                    route: UsersPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF06B6D4),
                      const Color(0xFF0891B2),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.shield_rounded,
                    title: 'Roles & Permissions',
                    route: RolesPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFFEC4899),
                      const Color(0xFFDB2777),
                    ],
                  ),
                  _DrawerTile(
                    icon: Icons.sync_rounded,
                    title: 'Sync Center',
                    route: SyncCenterPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF64748B),
                      const Color(0xFF475569),
                    ],
                  ),
                  const Divider(height: 32),
                  _DrawerTile(
                    icon: Icons.settings_rounded,
                    title: 'Settings',
                    route: SettingsPage.routePath,
                    currentRoute: currentRoute,
                    gradient: [
                      const Color(0xFF6B7280),
                      const Color(0xFF4B5563),
                    ],
                  ),
                ],
              ),
            ),
            Container(
              padding: const EdgeInsets.all(16),
              child: OutlinedButton.icon(
                onPressed: () {
                  ref.read(authControllerProvider.notifier).logout();
                  context.go(LoginPage.routePath);
                },
                icon: const Icon(Icons.logout_rounded),
                label: const Text('Sign Out'),
                style: OutlinedButton.styleFrom(
                  minimumSize: const Size(double.infinity, 48),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _DrawerTile extends StatelessWidget {
  const _DrawerTile({
    required this.icon,
    required this.title,
    required this.route,
    required this.currentRoute,
    required this.gradient,
  });

  final IconData icon;
  final String title;
  final String route;
  final String currentRoute;
  final List<Color> gradient;

  @override
  Widget build(BuildContext context) {
    final isSelected = currentRoute == route;
    final theme = Theme.of(context);

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        gradient: isSelected
            ? LinearGradient(
                colors: gradient,
                begin: Alignment.centerLeft,
                end: Alignment.centerRight,
              )
            : null,
        color: isSelected ? null : Colors.transparent,
      ),
      child: ListTile(
        leading: Container(
          padding: const EdgeInsets.all(8),
          decoration: BoxDecoration(
            color: isSelected
                ? Colors.white.withOpacity(0.2)
                : theme.colorScheme.surfaceContainerHighest,
            borderRadius: BorderRadius.circular(8),
          ),
          child: Icon(
            icon,
            color: isSelected ? Colors.white : theme.colorScheme.onSurface,
            size: 20,
          ),
        ),
        title: Text(
          title,
          style: TextStyle(
            color: isSelected ? Colors.white : theme.colorScheme.onSurface,
            fontWeight: isSelected ? FontWeight.w600 : FontWeight.normal,
          ),
        ),
        selected: isSelected,
        onTap: () {
          Navigator.pop(context);
          if (!isSelected) {
            context.go(route);
          }
        },
      ),
    );
  }
}


