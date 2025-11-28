import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/widgets/admin_drawer.dart';
import '../application/setting_controller.dart';
import '../domain/setting_models.dart';

class SettingsPage extends ConsumerWidget {
  const SettingsPage({super.key});

  static const routePath = '/settings';
  static const routeName = 'settings';

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final state = ref.watch(settingControllerProvider);
    final controller = ref.read(settingControllerProvider.notifier);
    final theme = Theme.of(context);

    return Scaffold(
      drawer: AdminDrawer(currentRoute: SettingsPage.routePath),
      appBar: AppBar(
        elevation: 0,
        title: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFFF59E0B), Color(0xFFD97706)],
                ),
                borderRadius: BorderRadius.circular(8),
              ),
              child: const Icon(Icons.settings_rounded, color: Colors.white, size: 20),
            ),
            const SizedBox(width: 12),
            const Text('Settings'),
          ],
        ),
      ),
      body: RefreshIndicator(
        onRefresh: controller.refresh,
        child: CustomScrollView(
          slivers: [
            if (state.errorMessage != null)
              SliverToBoxAdapter(
                child: Container(
                  margin: const EdgeInsets.all(16),
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    color: theme.colorScheme.errorContainer,
                    borderRadius: BorderRadius.circular(16),
                    border: Border.all(
                      color: theme.colorScheme.error.withOpacity(0.3),
                    ),
                  ),
                  child: Row(
                    children: [
                      Icon(Icons.error_outline_rounded, color: theme.colorScheme.error),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Text(
                          state.errorMessage!,
                          style: TextStyle(color: theme.colorScheme.onErrorContainer),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            if (state.successMessage != null)
              SliverToBoxAdapter(
                child: Container(
                  margin: const EdgeInsets.all(16),
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    color: const Color(0xFF10B981).withOpacity(0.1),
                    borderRadius: BorderRadius.circular(16),
                    border: Border.all(
                      color: const Color(0xFF10B981).withOpacity(0.3),
                    ),
                  ),
                  child: Row(
                    children: [
                      const Icon(Icons.check_circle_rounded, color: Color(0xFF10B981)),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Text(
                          state.successMessage!,
                          style: const TextStyle(color: Color(0xFF10B981)),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            if (state.isLoading)
              const SliverFillRemaining(
                hasScrollBody: false,
                child: Center(
                  child: CircularProgressIndicator(),
                ),
              )
            else
            SliverPadding(
              padding: const EdgeInsets.all(16),
              sliver: SliverList(
                delegate: SliverChildListDelegate([
                  _SettingsSection(
                    title: 'Store Information',
                    icon: Icons.store_rounded,
                    gradient: const [Color(0xFFF59E0B), Color(0xFFD97706)],
                    children: [
                      _SettingTile(
                        icon: Icons.business_rounded,
                        title: 'Store Name',
                        value: state.getSettingValue('store_name') ?? 'Not set',
                        onTap: () => _showStoreNameDialog(context, controller, state),
                      ),
                      _SettingTile(
                        icon: Icons.email_rounded,
                        title: 'Store Email',
                        value: state.getSettingValue('store_email') ?? 'Not set',
                        onTap: () => _showStoreEmailDialog(context, controller, state),
                      ),
                      _SettingTile(
                        icon: Icons.phone_rounded,
                        title: 'Store Phone',
                        value: state.getSettingValue('store_phone') ?? 'Not set',
                        onTap: () => _showStorePhoneDialog(context, controller, state),
                      ),
                      _SettingTile(
                        icon: Icons.location_on_rounded,
                        title: 'Store Address',
                        value: state.getSettingValue('store_address') ?? 'Not set',
                        onTap: () => _showStoreAddressDialog(context, controller, state),
                      ),
                      _SettingTile(
                        icon: Icons.currency_rupee_rounded,
                        title: 'Currency',
                        value: state.getSettingValue('currency') ?? 'INR',
                        onTap: () => _showCurrencyDialog(context, controller, state),
                      ),
                    ],
                  ),
                  const SizedBox(height: 16),
                  _SettingsSection(
                    title: 'System Actions',
                    icon: Icons.build_rounded,
                    gradient: const [Color(0xFF6366F1), Color(0xFF8B5CF6)],
                    children: [
                      _ActionTile(
                        icon: Icons.backup_rounded,
                        title: 'Create Backup',
                        subtitle: 'Backup database',
                        onTap: () => controller.createBackup(),
                        color: const Color(0xFF3B82F6),
                      ),
                      _ActionTile(
                        icon: Icons.cached_rounded,
                        title: 'Clear Cache',
                        subtitle: 'Clear application cache',
                        onTap: () => controller.clearCache(),
                        color: const Color(0xFF10B981),
                      ),
                      _ActionTile(
                        icon: Icons.system_update_rounded,
                        title: 'Update System',
                        subtitle: 'Run database migrations',
                        onTap: () => _showUpdateSystemDialog(context, controller),
                        color: const Color(0xFFF59E0B),
                      ),
                      _ActionTile(
                        icon: Icons.restore_rounded,
                        title: 'Reset Settings',
                        subtitle: 'Reset to default values',
                        onTap: () => _showResetDialog(context, controller),
                        color: const Color(0xFFEF4444),
                      ),
                    ],
                  ),
                ]),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Future<void> _showStoreNameDialog(
    BuildContext context,
    SettingController controller,
    SettingState state,
  ) async {
    final ctrl = TextEditingController(text: state.getSettingValue('store_name') ?? '');
    final result = await showDialog<String>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Store Name'),
        content: TextField(
          controller: ctrl,
          decoration: const InputDecoration(
            labelText: 'Store Name',
            border: OutlineInputBorder(),
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(ctrl.text),
            child: const Text('Save'),
          ),
        ],
      ),
    );
    if (result != null && result.isNotEmpty) {
      await controller.updateSettings(SettingsPayload(storeName: result));
    }
  }

  Future<void> _showStoreEmailDialog(
    BuildContext context,
    SettingController controller,
    SettingState state,
  ) async {
    final ctrl = TextEditingController(text: state.getSettingValue('store_email') ?? '');
    final result = await showDialog<String>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Store Email'),
        content: TextField(
          controller: ctrl,
          decoration: const InputDecoration(
            labelText: 'Store Email',
            border: OutlineInputBorder(),
          ),
          keyboardType: TextInputType.emailAddress,
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(ctrl.text),
            child: const Text('Save'),
          ),
        ],
      ),
    );
    if (result != null && result.isNotEmpty) {
      await controller.updateSettings(SettingsPayload(storeEmail: result));
    }
  }

  Future<void> _showStorePhoneDialog(
    BuildContext context,
    SettingController controller,
    SettingState state,
  ) async {
    final ctrl = TextEditingController(text: state.getSettingValue('store_phone') ?? '');
    final result = await showDialog<String>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Store Phone'),
        content: TextField(
          controller: ctrl,
          decoration: const InputDecoration(
            labelText: 'Store Phone',
            border: OutlineInputBorder(),
          ),
          keyboardType: TextInputType.phone,
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(ctrl.text),
            child: const Text('Save'),
          ),
        ],
      ),
    );
    if (result != null && result.isNotEmpty) {
      await controller.updateSettings(SettingsPayload(storePhone: result));
    }
  }

  Future<void> _showStoreAddressDialog(
    BuildContext context,
    SettingController controller,
    SettingState state,
  ) async {
    final ctrl = TextEditingController(text: state.getSettingValue('store_address') ?? '');
    final result = await showDialog<String>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Store Address'),
        content: TextField(
          controller: ctrl,
          decoration: const InputDecoration(
            labelText: 'Store Address',
            border: OutlineInputBorder(),
          ),
          maxLines: 3,
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(ctrl.text),
            child: const Text('Save'),
          ),
        ],
      ),
    );
    if (result != null && result.isNotEmpty) {
      await controller.updateSettings(SettingsPayload(storeAddress: result));
    }
  }

  Future<void> _showCurrencyDialog(
    BuildContext context,
    SettingController controller,
    SettingState state,
  ) async {
    final currencies = ['INR', 'USD', 'EUR', 'GBP', 'AED'];
    final current = state.getSettingValue('currency') ?? 'INR';
    
    String? selected = current;
    final result = await showDialog<String>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Currency'),
        content: StatefulBuilder(
          builder: (context, setState) => Column(
            mainAxisSize: MainAxisSize.min,
            children: currencies.map((currency) {
              return RadioListTile<String>(
                title: Text(currency),
                value: currency,
                groupValue: selected,
                onChanged: (value) {
                  setState(() => selected = value);
                },
              );
            }).toList(),
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(selected),
            child: const Text('Save'),
          ),
        ],
      ),
    );
    if (result != null) {
      await controller.updateSettings(SettingsPayload(currency: result));
    }
  }

  Future<void> _showUpdateSystemDialog(
    BuildContext context,
    SettingController controller,
  ) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Update System'),
        content: const Text('This will run database migrations. Continue?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(false),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(true),
            child: const Text('Update'),
          ),
        ],
      ),
    );
    if (confirm == true) {
      await controller.updateSystem();
    }
  }

  Future<void> _showResetDialog(
    BuildContext context,
    SettingController controller,
  ) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Reset Settings'),
        content: const Text('This will reset all settings to default values. Continue?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(false),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(true),
            style: ElevatedButton.styleFrom(foregroundColor: Colors.red),
            child: const Text('Reset'),
          ),
        ],
      ),
    );
    if (confirm == true) {
      await controller.resetSettings();
    }
  }
}

class _SettingsSection extends StatelessWidget {
  const _SettingsSection({
    required this.title,
    required this.icon,
    required this.gradient,
    required this.children,
  });

  final String title;
  final IconData icon;
  final List<Color> gradient;
  final List<Widget> children;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    
    return Container(
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [
            theme.colorScheme.surfaceContainerHighest.withOpacity(0.5),
            theme.colorScheme.surfaceContainerHighest.withOpacity(0.2),
          ],
        ),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(
          color: theme.colorScheme.outline.withOpacity(0.1),
        ),
        boxShadow: [
          BoxShadow(
            color: theme.colorScheme.shadow.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              gradient: LinearGradient(colors: gradient),
              borderRadius: const BorderRadius.vertical(top: Radius.circular(20)),
            ),
            child: Row(
              children: [
                Container(
                  padding: const EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: Colors.white.withOpacity(0.2),
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: Icon(icon, color: Colors.white, size: 20),
                ),
                const SizedBox(width: 12),
                Text(
                  title,
                  style: theme.textTheme.titleLarge?.copyWith(
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
          ),
          ...children,
        ],
      ),
    );
  }
}

class _SettingTile extends StatelessWidget {
  const _SettingTile({
    required this.icon,
    required this.title,
    required this.value,
    required this.onTap,
  });

  final IconData icon;
  final String title;
  final String value;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
          child: Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: theme.colorScheme.primaryContainer,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Icon(icon, size: 20, color: theme.colorScheme.onPrimaryContainer),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: theme.textTheme.bodyLarge?.copyWith(
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      value,
                      style: theme.textTheme.bodySmall?.copyWith(
                        color: theme.colorScheme.onSurfaceVariant,
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ],
                ),
              ),
              Icon(Icons.chevron_right_rounded, color: theme.colorScheme.onSurfaceVariant),
            ],
          ),
        ),
      ),
    );
  }
}

class _ActionTile extends StatelessWidget {
  const _ActionTile({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.onTap,
    required this.color,
  });

  final IconData icon;
  final String title;
  final String subtitle;
  final VoidCallback onTap;
  final Color color;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
          child: Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: color.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Icon(icon, size: 20, color: color),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: theme.textTheme.bodyLarge?.copyWith(
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      subtitle,
                      style: theme.textTheme.bodySmall?.copyWith(
                        color: theme.colorScheme.onSurfaceVariant,
                      ),
                    ),
                  ],
                ),
              ),
              Icon(Icons.chevron_right_rounded, color: theme.colorScheme.onSurfaceVariant),
            ],
          ),
        ),
      ),
    );
  }
}
