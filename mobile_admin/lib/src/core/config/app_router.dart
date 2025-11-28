import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';

import '../../features/auth/application/auth_controller.dart';
import '../../features/auth/presentation/login_page.dart';
import '../../features/ads/presentation/ads_page.dart';
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
import '../../features/settings/presentation/settings_page.dart';
import '../../features/dashboard/presentation/dashboard_page.dart';
import '../../features/inventory/presentation/inventory_page.dart';
import '../../features/menu/presentation/menu_page.dart';
import '../../features/pos/presentation/pos_page.dart';
import '../../features/reports/presentation/reports_page.dart';
import '../../features/delivery/presentation/orders_page.dart';
import '../../features/delivery/presentation/notifications_page.dart';
import '../../sync/sync_center_page.dart';

final appRouterProvider = Provider<GoRouter>((ref) {
  final notifier = RouterNotifier(ref);

  return GoRouter(
    initialLocation: DashboardPage.routePath,
    refreshListenable: notifier,
    redirect: notifier.handleRedirect,
    routes: [
      GoRoute(
        path: LoginPage.routePath,
        name: LoginPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: LoginPage()),
      ),
      GoRoute(
        path: DashboardPage.routePath,
        name: DashboardPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: DashboardPage()),
      ),
      GoRoute(
        path: CatalogPage.routePath,
        name: CatalogPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: CatalogPage()),
      ),
      GoRoute(
        path: CategoriesPage.routePath,
        name: CategoriesPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: CategoriesPage()),
      ),
      GoRoute(
        path: BrandsPage.routePath,
        name: BrandsPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: BrandsPage()),
      ),
      GoRoute(
        path: BranchesPage.routePath,
        name: BranchesPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: BranchesPage()),
      ),
      GoRoute(
        path: TransfersPage.routePath,
        name: TransfersPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: TransfersPage()),
      ),
      GoRoute(
        path: RegistersPage.routePath,
        name: RegistersPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: RegistersPage()),
      ),
      GoRoute(
        path: ShiftsPage.routePath,
        name: ShiftsPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: ShiftsPage()),
      ),
      GoRoute(
        path: SalesHistoryPage.routePath,
        name: SalesHistoryPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: SalesHistoryPage()),
      ),
      GoRoute(
        path: CustomersPage.routePath,
        name: CustomersPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: CustomersPage()),
      ),
      GoRoute(
        path: UsersPage.routePath,
        name: UsersPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: UsersPage()),
      ),
      GoRoute(
        path: RolesPage.routePath,
        name: RolesPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: RolesPage()),
      ),
      GoRoute(
        path: SettingsPage.routePath,
        name: SettingsPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: SettingsPage()),
      ),
      GoRoute(
        path: InventoryPage.routePath,
        name: InventoryPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: InventoryPage()),
      ),
      GoRoute(
        path: PosPage.routePath,
        name: PosPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: PosPage()),
      ),
      GoRoute(
        path: AdsPage.routePath,
        name: AdsPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: AdsPage()),
      ),
      GoRoute(
        path: ReportsPage.routePath,
        name: ReportsPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: ReportsPage()),
      ),
      GoRoute(
        path: SyncCenterPage.routePath,
        name: SyncCenterPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: SyncCenterPage()),
      ),
      GoRoute(
        path: MenuPage.routePath,
        name: MenuPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: MenuPage()),
      ),
      GoRoute(
        path: OrdersPage.routePath,
        name: OrdersPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: OrdersPage()),
      ),
      GoRoute(
        path: NotificationsPage.routePath,
        name: NotificationsPage.routeName,
        pageBuilder: (context, state) => const NoTransitionPage(child: NotificationsPage()),
      ),
    ],
  );
});

class RouterNotifier extends ChangeNotifier {
  RouterNotifier(this.ref) {
    ref.listen<AuthState>(authControllerProvider, (_, __) => notifyListeners());
  }

  final Ref ref;

  String? handleRedirect(BuildContext context, GoRouterState state) {
    final authState = ref.read(authControllerProvider);
    final isLoggingIn = state.matchedLocation == LoginPage.routePath;

    if (!authState.isAuthenticated) {
      return isLoggingIn ? null : LoginPage.routePath;
    }

    if (isLoggingIn) {
      return DashboardPage.routePath;
    }

    return null;
  }
}

