import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/widgets/admin_drawer.dart';
import '../application/branch_controller.dart';
import '../application/purchase_controller.dart';
import '../data/inventory_repository.dart';
import '../domain/purchase_models.dart';

class InventoryPage extends ConsumerWidget {
  const InventoryPage({super.key});

  static const routePath = '/inventory';
  static const routeName = 'inventory';

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final state = ref.watch(purchaseControllerProvider);
    final controller = ref.read(purchaseControllerProvider.notifier);
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
                  colors: [Color(0xFFF59E0B), Color(0xFFD97706)],
                ),
                borderRadius: BorderRadius.circular(8),
              ),
              child: const Icon(Icons.warehouse_rounded, color: Colors.white, size: 20),
            ),
            const SizedBox(width: 12),
            const Text('Purchases'),
          ],
        ),
        actions: [
          if (state.offlineQueue.isNotEmpty)
            Badge(
              label: Text('${state.offlineQueue.length}'),
              child: IconButton(
                icon: const Icon(Icons.cloud_upload_rounded),
                tooltip: 'Sync offline queue',
                onPressed: controller.syncOfflineQueue,
              ),
            )
          else
            IconButton(
              icon: const Icon(Icons.cloud_upload_rounded),
              tooltip: 'Sync offline queue',
              onPressed: controller.syncOfflineQueue,
            ),
        ],
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () => _showPurchaseSheet(context, controller, ref),
        icon: const Icon(Icons.add_rounded),
        label: const Text('Purchase'),
        backgroundColor: theme.colorScheme.primary,
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
            if (state.offlineQueue.isNotEmpty)
              SliverToBoxAdapter(
                child: Padding(
                  padding: const EdgeInsets.fromLTRB(16, 16, 16, 8),
                  child: Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      gradient: LinearGradient(
                        colors: [
                          const Color(0xFFF59E0B).withOpacity(0.1),
                          const Color(0xFFD97706).withOpacity(0.05),
                        ],
                      ),
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(
                        color: const Color(0xFFF59E0B).withOpacity(0.3),
                      ),
                    ),
                    child: Row(
                      children: [
                        Container(
                          padding: const EdgeInsets.all(10),
                          decoration: BoxDecoration(
                            color: const Color(0xFFF59E0B).withOpacity(0.2),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: const Icon(
                            Icons.cloud_upload_rounded,
                            color: Color(0xFFD97706),
                          ),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          child: Text(
                            '${state.offlineQueue.length} purchase(s) pending sync',
                            style: theme.textTheme.bodyMedium?.copyWith(
                              color: const Color(0xFFD97706),
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            if (state.purchases.isEmpty)
              SliverFillRemaining(
                hasScrollBody: false,
                child: Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(
                        Icons.warehouse_outlined,
                        size: 80,
                        color: theme.colorScheme.outline,
                      ),
                      const SizedBox(height: 16),
                      Text(
                        'No purchases yet',
                        style: theme.textTheme.titleLarge,
                      ),
                      const SizedBox(height: 8),
                      Text(
                        'Pull down to refresh',
                        style: theme.textTheme.bodyMedium?.copyWith(
                          color: theme.colorScheme.onSurfaceVariant,
                        ),
                      ),
                    ],
                  ),
                ),
              )
            else
              SliverPadding(
                padding: const EdgeInsets.all(16),
                sliver: SliverList(
                  delegate: SliverChildBuilderDelegate(
                    (context, index) {
                      final purchase = state.purchases[index];
                      return Padding(
                        padding: const EdgeInsets.only(bottom: 12),
                        child: _PurchaseCard(purchase: purchase),
                      );
                    },
                    childCount: state.purchases.length,
                  ),
                ),
              ),
          ],
        ),
      ),
    );
  }

  Future<void> _showPurchaseSheet(
    BuildContext context,
    PurchaseController controller,
    WidgetRef ref,
  ) {
    final supplierRepo = ref.read(supplierRepositoryProvider);
    final branchState = ref.read(branchControllerProvider);
    return showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      builder: (_) => _PurchaseForm(
        controller: controller,
        supplierRepository: supplierRepo,
        branchesState: branchState,
      ),
    );
  }
}

class _PurchaseForm extends ConsumerStatefulWidget {
  const _PurchaseForm({
    required this.controller,
    this.purchase,
    required this.supplierRepository,
    required this.branchesState,
  });

  final PurchaseController controller;
  final PurchaseDto? purchase;
  final SupplierRepository supplierRepository;
  final BranchState branchesState;

  @override
  ConsumerState<_PurchaseForm> createState() => _PurchaseFormState();
}

class _PurchaseFormState extends ConsumerState<_PurchaseForm> {
  final _formKey = GlobalKey<FormState>();
  final _subtotalCtrl = TextEditingController();
  final _taxCtrl = TextEditingController();
  final _discountCtrl = TextEditingController();
  final _totalCtrl = TextEditingController();
  final _notesCtrl = TextEditingController();
  int? _supplierId;
  int? _branchId;
  DateTime _purchaseDate = DateTime.now();
  DateTime? _expectedDate;

  @override
  void initState() {
    super.initState();
    if (widget.purchase != null) {
      _supplierId = widget.purchase!.supplierId;
      _branchId = widget.purchase!.branchId;
      _purchaseDate = widget.purchase!.purchaseDate;
      _expectedDate = widget.purchase!.expectedDate;
      _subtotalCtrl.text = widget.purchase!.subtotal.toString();
      _taxCtrl.text = widget.purchase!.taxAmount.toString();
      _discountCtrl.text = widget.purchase!.discountAmount.toString();
      _totalCtrl.text = widget.purchase!.totalAmount.toString();
      _notesCtrl.text = widget.purchase!.notes ?? '';
    }
    _calculateTotal();
  }

  @override
  void dispose() {
    _subtotalCtrl.dispose();
    _taxCtrl.dispose();
    _discountCtrl.dispose();
    _totalCtrl.dispose();
    _notesCtrl.dispose();
    super.dispose();
  }

  void _calculateTotal() {
    final subtotal = double.tryParse(_subtotalCtrl.text) ?? 0;
    final tax = double.tryParse(_taxCtrl.text) ?? 0;
    final discount = double.tryParse(_discountCtrl.text) ?? 0;
    final total = subtotal + tax - discount;
    _totalCtrl.text = total.toStringAsFixed(2);
  }

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    final suppliersFuture = widget.supplierRepository.fetchSuppliers(activeOnly: true);
    final branchesState = widget.branchesState;

    return Container(
      padding: EdgeInsets.only(
        left: 16,
        right: 16,
        bottom: MediaQuery.of(context).viewInsets.bottom + 16,
        top: 24,
      ),
      decoration: BoxDecoration(
        color: theme.colorScheme.surface,
        borderRadius: const BorderRadius.vertical(top: Radius.circular(24)),
      ),
      child: Form(
        key: _formKey,
        child: SingleChildScrollView(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Center(
                child: Container(
                  width: 40,
                  height: 4,
                  decoration: BoxDecoration(
                    color: theme.colorScheme.outline.withOpacity(0.3),
                    borderRadius: BorderRadius.circular(2),
                  ),
                ),
              ),
              const SizedBox(height: 16),
              Text(
                widget.purchase == null ? 'New Purchase' : 'Edit Purchase',
                style: theme.textTheme.titleLarge?.copyWith(
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 24),
              FutureBuilder<List<SupplierDto>>(
                future: suppliersFuture,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return const Padding(
                      padding: EdgeInsets.all(16.0),
                      child: Center(child: CircularProgressIndicator()),
                    );
                  }
                  if (snapshot.hasError) {
                    return Text('Error: ${snapshot.error}');
                  }
                  final suppliers = snapshot.data ?? [];
                  return DropdownButtonFormField<int>(
                    value: _supplierId,
                    decoration: InputDecoration(
                      labelText: 'Supplier *',
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                    ),
                    items: suppliers
                        .map((supplier) => DropdownMenuItem<int>(
                              value: supplier.id,
                              child: Text(supplier.name),
                            ))
                        .toList(),
                    onChanged: (value) => setState(() => _supplierId = value),
                    validator: (value) => value == null ? 'Required' : null,
                  );
                },
              ),
              const SizedBox(height: 16),
              DropdownButtonFormField<int>(
                value: _branchId,
                decoration: InputDecoration(
                  labelText: 'Branch *',
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                ),
                items: branchesState.branches
                    .map((branch) => DropdownMenuItem<int>(
                          value: branch.id,
                          child: Text(branch.name),
                        ))
                    .toList(),
                onChanged: (value) => setState(() => _branchId = value),
                validator: (value) => value == null ? 'Required' : null,
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _subtotalCtrl,
                decoration: InputDecoration(
                  labelText: 'Subtotal *',
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                ),
                keyboardType: TextInputType.number,
                validator: (value) => value == null || value.isEmpty ? 'Required' : null,
                onChanged: (_) => _calculateTotal(),
              ),
              const SizedBox(height: 16),
              Row(
                children: [
                  Expanded(
                    child: TextFormField(
                      controller: _taxCtrl,
                      decoration: InputDecoration(
                        labelText: 'Tax',
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                      ),
                      keyboardType: TextInputType.number,
                      onChanged: (_) => _calculateTotal(),
                    ),
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: TextFormField(
                      controller: _discountCtrl,
                      decoration: InputDecoration(
                        labelText: 'Discount',
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                      ),
                      keyboardType: TextInputType.number,
                      onChanged: (_) => _calculateTotal(),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _totalCtrl,
                decoration: InputDecoration(
                  labelText: 'Total Amount *',
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                ),
                keyboardType: TextInputType.number,
                readOnly: true,
                validator: (value) => value == null || value.isEmpty ? 'Required' : null,
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _notesCtrl,
                decoration: InputDecoration(
                  labelText: 'Notes',
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                ),
                maxLines: 3,
              ),
              const SizedBox(height: 24),
              SizedBox(
                width: double.infinity,
                height: 50,
                child: ElevatedButton(
                  onPressed: () async {
                    if (!_formKey.currentState!.validate()) return;
                    final payload = PurchasePayload(
                      supplierId: _supplierId!,
                      branchId: _branchId!,
                      purchaseDate: _purchaseDate,
                      expectedDate: _expectedDate,
                      subtotal: double.parse(_subtotalCtrl.text),
                      taxAmount: _taxCtrl.text.isNotEmpty ? double.tryParse(_taxCtrl.text) : null,
                      discountAmount: _discountCtrl.text.isNotEmpty ? double.tryParse(_discountCtrl.text) : null,
                      totalAmount: double.parse(_totalCtrl.text),
                      status: widget.purchase?.status ?? 'pending',
                      notes: _notesCtrl.text.trim().isEmpty ? null : _notesCtrl.text.trim(),
                    );
                    if (widget.purchase == null) {
                      await widget.controller.createPurchase(payload);
                    } else {
                      await widget.controller.updatePurchase(widget.purchase!.id, payload);
                    }
                    if (mounted) Navigator.of(context).pop();
                  },
                  style: ElevatedButton.styleFrom(
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                  ),
                  child: Text(widget.purchase == null ? 'Create Purchase' : 'Update Purchase'),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class _PurchaseCard extends ConsumerWidget {
  const _PurchaseCard({required this.purchase});

  final PurchaseDto purchase;

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final theme = Theme.of(context);
    final controller = ref.read(purchaseControllerProvider.notifier);
    final statusColor = _getStatusColor(purchase.status);
    
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
          color: statusColor.withOpacity(0.3),
          width: 1.5,
        ),
        boxShadow: [
          BoxShadow(
            color: theme.colorScheme.shadow.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          onTap: () => _showDetails(context, purchase),
          borderRadius: BorderRadius.circular(20),
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(
                          colors: [Color(0xFFF59E0B), Color(0xFFD97706)],
                        ),
                        borderRadius: BorderRadius.circular(12),
                        boxShadow: [
                          BoxShadow(
                            color: const Color(0xFFF59E0B).withOpacity(0.3),
                            blurRadius: 8,
                            offset: const Offset(0, 2),
                          ),
                        ],
                      ),
                      child: const Icon(Icons.shopping_cart_rounded, color: Colors.white, size: 24),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            purchase.purchaseNumber,
                            style: theme.textTheme.titleLarge?.copyWith(
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          const SizedBox(height: 4),
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                            decoration: BoxDecoration(
                              color: statusColor.withOpacity(0.2),
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Row(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                Icon(
                                  _getStatusIcon(purchase.status),
                                  size: 12,
                                  color: statusColor,
                                ),
                                const SizedBox(width: 4),
                                Text(
                                  purchase.status.toUpperCase(),
                                  style: theme.textTheme.bodySmall?.copyWith(
                                    color: statusColor,
                                    fontWeight: FontWeight.w600,
                                    fontSize: 11,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
                    PopupMenuButton(
                      itemBuilder: (context) => [
                        if (purchase.status == 'pending')
                          PopupMenuItem(
                            child: const Row(
                              children: [
                                Icon(Icons.check_circle_rounded, size: 20, color: Color(0xFF10B981)),
                                SizedBox(width: 8),
                                Text('Mark Received'),
                              ],
                            ),
                            onTap: () => Future.delayed(
                              const Duration(milliseconds: 100),
                              () => controller.markReceived(purchase.id),
                            ),
                          ),
                        PopupMenuItem(
                          child: const Row(
                            children: [
                              Icon(Icons.edit_rounded, size: 20),
                              SizedBox(width: 8),
                              Text('Edit'),
                            ],
                          ),
                          onTap: () => Future.delayed(
                            const Duration(milliseconds: 100),
                            () => _showEditSheet(context, controller, purchase, ref),
                          ),
                        ),
                        if (purchase.status == 'pending')
                          PopupMenuItem(
                            child: const Row(
                              children: [
                                Icon(Icons.cancel_rounded, size: 20, color: Colors.orange),
                                SizedBox(width: 8),
                                Text('Cancel', style: TextStyle(color: Colors.orange)),
                              ],
                            ),
                            onTap: () => Future.delayed(
                              const Duration(milliseconds: 100),
                              () => controller.cancelPurchase(purchase.id),
                            ),
                          ),
                        PopupMenuItem(
                          child: const Row(
                            children: [
                              Icon(Icons.delete_rounded, size: 20, color: Colors.red),
                              SizedBox(width: 8),
                              Text('Delete', style: TextStyle(color: Colors.red)),
                            ],
                          ),
                          onTap: () => Future.delayed(
                            const Duration(milliseconds: 100),
                            () => _showDeleteDialog(context, controller, purchase),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
                const SizedBox(height: 16),
                Row(
                  children: [
                    Expanded(
                      child: Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(
                          color: theme.colorScheme.secondaryContainer.withOpacity(0.5),
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'SUPPLIER',
                              style: theme.textTheme.bodySmall?.copyWith(
                                color: theme.colorScheme.onSecondaryContainer,
                                fontWeight: FontWeight.bold,
                                fontSize: 10,
                              ),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              purchase.supplierName,
                              style: theme.textTheme.bodyMedium?.copyWith(
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(
                          color: theme.colorScheme.tertiaryContainer.withOpacity(0.5),
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'BRANCH',
                              style: theme.textTheme.bodySmall?.copyWith(
                                color: theme.colorScheme.onTertiaryContainer,
                                fontWeight: FontWeight.bold,
                                fontSize: 10,
                              ),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              purchase.branchName,
                              style: theme.textTheme.bodyMedium?.copyWith(
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Total Amount',
                          style: theme.textTheme.bodySmall?.copyWith(
                            color: theme.colorScheme.onSurfaceVariant,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          '₹${purchase.totalAmount.toStringAsFixed(2)}',
                          style: theme.textTheme.titleLarge?.copyWith(
                            fontWeight: FontWeight.bold,
                            color: theme.colorScheme.primary,
                          ),
                        ),
                      ],
                    ),
                    if (purchase.purchaseDate != null)
                      Row(
                        children: [
                          Icon(Icons.calendar_today_rounded, size: 16, color: theme.colorScheme.onSurfaceVariant),
                          const SizedBox(width: 4),
                          Text(
                            purchase.purchaseDate.toLocal().toString().split(' ')[0],
                            style: theme.textTheme.bodySmall?.copyWith(
                              color: theme.colorScheme.onSurfaceVariant,
                            ),
                          ),
                        ],
                      ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Color _getStatusColor(String status) {
    switch (status.toLowerCase()) {
      case 'received':
      case 'completed':
        return const Color(0xFF10B981);
      case 'pending':
        return const Color(0xFFF59E0B);
      case 'cancelled':
        return const Color(0xFFEF4444);
      default:
        return const Color(0xFF6B7280);
    }
  }

  IconData _getStatusIcon(String status) {
    switch (status.toLowerCase()) {
      case 'received':
      case 'completed':
        return Icons.check_circle_rounded;
      case 'pending':
        return Icons.pending_rounded;
      case 'cancelled':
        return Icons.cancel_rounded;
      default:
        return Icons.help_outline_rounded;
    }
  }

  void _showDetails(BuildContext context, PurchaseDto purchase) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      builder: (context) => _PurchaseDetailsSheet(purchase: purchase),
    );
  }

  void _showEditSheet(
    BuildContext context,
    PurchaseController controller,
    PurchaseDto purchase,
    WidgetRef ref,
  ) {
    final supplierRepo = ref.read(supplierRepositoryProvider);
    final branchState = ref.read(branchControllerProvider);
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      builder: (_) => _PurchaseForm(
        controller: controller,
        purchase: purchase,
        supplierRepository: supplierRepo,
        branchesState: branchState,
      ),
    );
  }

  Future<void> _showDeleteDialog(
    BuildContext context,
    PurchaseController controller,
    PurchaseDto purchase,
  ) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Delete Purchase'),
        content: Text('Are you sure you want to delete "${purchase.purchaseNumber}"?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(false),
            child: const Text('Cancel'),
          ),
          TextButton(
            onPressed: () => Navigator.of(context).pop(true),
            style: TextButton.styleFrom(foregroundColor: Colors.red),
            child: const Text('Delete'),
          ),
        ],
      ),
    );

    if (confirm == true && context.mounted) {
      await controller.deletePurchase(purchase.id);
      if (context.mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: const Text('Purchase deleted'),
            behavior: SnackBarBehavior.floating,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          ),
        );
      }
    }
  }
}

class _PurchaseDetailsSheet extends StatelessWidget {
  const _PurchaseDetailsSheet({required this.purchase});

  final PurchaseDto purchase;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: theme.colorScheme.surface,
        borderRadius: const BorderRadius.vertical(top: Radius.circular(24)),
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Center(
            child: Container(
              width: 40,
              height: 4,
              decoration: BoxDecoration(
                color: theme.colorScheme.outline.withOpacity(0.3),
                borderRadius: BorderRadius.circular(2),
              ),
            ),
          ),
          const SizedBox(height: 16),
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [Color(0xFFF59E0B), Color(0xFFD97706)],
                  ),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.shopping_cart_rounded, color: Colors.white, size: 24),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      purchase.purchaseNumber,
                      style: theme.textTheme.titleLarge?.copyWith(
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    Text(
                      purchase.status,
                      style: theme.textTheme.bodyMedium?.copyWith(
                        color: theme.colorScheme.onSurfaceVariant,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 24),
          _DetailRow(icon: Icons.business_rounded, label: 'Supplier', value: purchase.supplierName),
          _DetailRow(icon: Icons.store_rounded, label: 'Branch', value: purchase.branchName),
          _DetailRow(icon: Icons.calendar_today_rounded, label: 'Purchase Date', value: purchase.purchaseDate.toLocal().toString().split(' ')[0]),
          _DetailRow(icon: Icons.attach_money_rounded, label: 'Total Amount', value: '₹${purchase.totalAmount.toStringAsFixed(2)}'),
          if (purchase.notes != null && purchase.notes!.isNotEmpty)
            _DetailRow(icon: Icons.note_rounded, label: 'Notes', value: purchase.notes!),
        ],
      ),
    );
  }
}

class _DetailRow extends StatelessWidget {
  const _DetailRow({required this.icon, required this.label, required this.value});

  final IconData icon;
  final String label;
  final String value;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Icon(icon, size: 20, color: theme.colorScheme.primary),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: theme.textTheme.bodySmall?.copyWith(
                    color: theme.colorScheme.onSurfaceVariant,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  value,
                  style: theme.textTheme.bodyMedium?.copyWith(
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

