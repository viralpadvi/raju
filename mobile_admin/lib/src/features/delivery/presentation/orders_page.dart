import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:intl/intl.dart';

import '../../../core/widgets/admin_drawer.dart';
import '../application/order_controller.dart';
import '../domain/order_models.dart';

class OrdersPage extends ConsumerStatefulWidget {
  const OrdersPage({super.key});

  static const routePath = '/delivery/orders';
  static const routeName = 'delivery-orders';

  @override
  ConsumerState<OrdersPage> createState() => _OrdersPageState();
}

class _OrdersPageState extends ConsumerState<OrdersPage> {
  final _searchCtrl = TextEditingController();
  String? _selectedStatus;

  @override
  void dispose() {
    _searchCtrl.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final state = ref.watch(orderControllerProvider);
    final controller = ref.read(orderControllerProvider.notifier);
    final theme = Theme.of(context);

    return Scaffold(
      drawer: AdminDrawer(currentRoute: OrdersPage.routePath),
      appBar: AppBar(
        elevation: 0,
        title: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF3B82F6), Color(0xFF2563EB)],
                ),
                borderRadius: BorderRadius.circular(8),
              ),
              child: const Icon(Icons.local_shipping_rounded, color: Colors.white, size: 20),
            ),
            const SizedBox(width: 12),
            const Text('Delivery Orders'),
          ],
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.filter_list_rounded),
            tooltip: 'Filter by Status',
            onPressed: () => _showStatusFilter(context, controller),
          ),
        ],
      ),
      body: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: theme.colorScheme.surfaceContainerHighest.withOpacity(0.3),
              border: Border(
                bottom: BorderSide(
                  color: theme.colorScheme.outline.withOpacity(0.1),
                ),
              ),
            ),
            child: TextField(
              controller: _searchCtrl,
              decoration: InputDecoration(
                hintText: 'Search by order number...',
                prefixIcon: const Icon(Icons.search_rounded),
                suffixIcon: _searchCtrl.text.isNotEmpty
                    ? IconButton(
                        icon: const Icon(Icons.clear_rounded),
                        onPressed: () {
                          _searchCtrl.clear();
                          controller.refresh();
                        },
                      )
                    : null,
                filled: true,
                fillColor: theme.colorScheme.surface,
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                  borderSide: BorderSide.none,
                ),
                contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
              ),
              onChanged: (value) {
                setState(() {});
                if (value.isEmpty || value.length >= 3) {
                  controller.refresh(
                    search: value.isEmpty ? null : value,
                    status: _selectedStatus,
                  );
                }
              },
            ),
          ),
          Expanded(
            child: RefreshIndicator(
              onRefresh: () => controller.refresh(
                search: _searchCtrl.text.isEmpty ? null : _searchCtrl.text,
                status: _selectedStatus,
              ),
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
                  if (state.isLoading && state.orders.isEmpty)
                    const SliverFillRemaining(
                      child: Center(child: CircularProgressIndicator()),
                    ),
                  if (state.orders.isEmpty && !state.isLoading)
                    SliverFillRemaining(
                      hasScrollBody: false,
                      child: Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(
                              Icons.inbox_rounded,
                              size: 64,
                              color: theme.colorScheme.outline.withOpacity(0.5),
                            ),
                            const SizedBox(height: 16),
                            Text(
                              'No orders found',
                              style: theme.textTheme.titleMedium?.copyWith(
                                color: theme.colorScheme.onSurface.withOpacity(0.6),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  if (state.orders.isNotEmpty)
                    SliverPadding(
                      padding: const EdgeInsets.all(16),
                      sliver: SliverList(
                        delegate: SliverChildBuilderDelegate(
                          (context, index) {
                            final order = state.orders[index];
                            return _OrderCard(order: order, controller: controller);
                          },
                          childCount: state.orders.length,
                        ),
                      ),
                    ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _showStatusFilter(BuildContext context, OrderController controller) {
    showModalBottomSheet(
      context: context,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) => Container(
        padding: const EdgeInsets.all(24),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Filter by Status',
              style: Theme.of(context).textTheme.titleLarge,
            ),
            const SizedBox(height: 16),
            ...[
              {'label': 'All', 'value': null},
              {'label': 'Pending', 'value': 'pending'},
              {'label': 'Assigned', 'value': 'assigned'},
              {'label': 'Picked Up', 'value': 'picked_up'},
              {'label': 'In Transit', 'value': 'in_transit'},
              {'label': 'Delivered', 'value': 'delivered'},
            ].map((status) => ListTile(
                  title: Text(status['label'] as String),
                  trailing: _selectedStatus == status['value']
                      ? const Icon(Icons.check_rounded, color: Colors.blue)
                      : null,
                  onTap: () {
                    setState(() {
                      _selectedStatus = status['value'] as String?;
                    });
                    controller.refresh(
                      search: _searchCtrl.text.isEmpty ? null : _searchCtrl.text,
                      status: _selectedStatus,
                    );
                    Navigator.pop(context);
                  },
                )),
          ],
        ),
      ),
    );
  }
}

class _OrderCard extends StatelessWidget {
  const _OrderCard({
    required this.order,
    required this.controller,
  });

  final OrderDto order;
  final OrderController controller;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    final dateFormat = DateFormat('MMM dd, yyyy • hh:mm a');

    Color statusColor;
    IconData statusIcon;
    String statusText;

    switch (order.status) {
      case 'pending':
        statusColor = Colors.orange;
        statusIcon = Icons.pending_rounded;
        statusText = 'Pending';
        break;
      case 'assigned':
        statusColor = Colors.blue;
        statusIcon = Icons.assignment_rounded;
        statusText = 'Assigned';
        break;
      case 'picked_up':
        statusColor = Colors.purple;
        statusIcon = Icons.inventory_2_rounded;
        statusText = 'Picked Up';
        break;
      case 'in_transit':
        statusColor = Colors.indigo;
        statusIcon = Icons.local_shipping_rounded;
        statusText = 'In Transit';
        break;
      case 'delivered':
        statusColor = Colors.green;
        statusIcon = Icons.check_circle_rounded;
        statusText = 'Delivered';
        break;
      default:
        statusColor = Colors.grey;
        statusIcon = Icons.help_outline_rounded;
        statusText = order.status;
    }

    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      elevation: 0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(16),
        side: BorderSide(
          color: theme.colorScheme.outline.withOpacity(0.1),
        ),
      ),
      child: InkWell(
        borderRadius: BorderRadius.circular(16),
        onTap: () => _showOrderDetails(context, order),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                    decoration: BoxDecoration(
                      color: statusColor.withOpacity(0.1),
                      borderRadius: BorderRadius.circular(8),
                      border: Border.all(color: statusColor.withOpacity(0.3)),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(statusIcon, size: 16, color: statusColor),
                        const SizedBox(width: 6),
                        Text(
                          statusText,
                          style: TextStyle(
                            color: statusColor,
                            fontWeight: FontWeight.w600,
                            fontSize: 12,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const Spacer(),
                  Text(
                    order.orderNumber,
                    style: theme.textTheme.titleMedium?.copyWith(
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              Row(
                children: [
                  Icon(Icons.person_rounded, size: 16, color: theme.colorScheme.onSurface.withOpacity(0.6)),
                  const SizedBox(width: 8),
                  Expanded(
                    child: Text(
                      order.customerName,
                      style: theme.textTheme.bodyMedium,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 8),
              if (order.deliveryAddress != null)
                Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Icon(Icons.location_on_rounded, size: 16, color: theme.colorScheme.onSurface.withOpacity(0.6)),
                    const SizedBox(width: 8),
                    Expanded(
                      child: Text(
                        order.formattedAddress,
                        style: theme.textTheme.bodySmall?.copyWith(
                          color: theme.colorScheme.onSurface.withOpacity(0.7),
                        ),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ),
                  ],
                ),
              const SizedBox(height: 12),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text(
                    'Total: ${NumberFormat.currency(symbol: '\$').format(order.totalAmount)}',
                    style: theme.textTheme.titleMedium?.copyWith(
                      fontWeight: FontWeight.bold,
                      color: theme.colorScheme.primary,
                    ),
                  ),
                  if (order.createdAt != null)
                    Text(
                      dateFormat.format(order.createdAt!),
                      style: theme.textTheme.bodySmall?.copyWith(
                        color: theme.colorScheme.onSurface.withOpacity(0.6),
                      ),
                    ),
                ],
              ),
              if (order.isAssigned || order.isPending)
                Padding(
                  padding: const EdgeInsets.only(top: 12),
                  child: Row(
                    children: [
                      if (order.isPending)
                        Expanded(
                          child: OutlinedButton.icon(
                            onPressed: () => _acceptOrder(context),
                            icon: const Icon(Icons.check_rounded, size: 18),
                            label: const Text('Accept'),
                            style: OutlinedButton.styleFrom(
                              foregroundColor: Colors.blue,
                            ),
                          ),
                        ),
                      if (order.isAssigned) ...[
                        Expanded(
                          child: OutlinedButton.icon(
                            onPressed: () => _pickupOrder(context),
                            icon: const Icon(Icons.inventory_2_rounded, size: 18),
                            label: const Text('Pick Up'),
                            style: OutlinedButton.styleFrom(
                              foregroundColor: Colors.purple,
                            ),
                          ),
                        ),
                        const SizedBox(width: 8),
                      ],
                      if (order.isPickedUp || order.isInTransit)
                        Expanded(
                          child: ElevatedButton.icon(
                            onPressed: () => _deliverOrder(context),
                            icon: const Icon(Icons.check_circle_rounded, size: 18),
                            label: const Text('Deliver'),
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.green,
                              foregroundColor: Colors.white,
                            ),
                          ),
                        ),
                    ],
                  ),
                ),
            ],
          ),
        ),
      ),
    );
  }

  void _acceptOrder(BuildContext context) async {
    final success = await controller.acceptOrder(order.id);
    if (context.mounted) {
      if (success) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Order accepted successfully')),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Failed to accept order: ${controller.state.errorMessage ?? 'Unknown error'}')),
        );
      }
    }
  }

  void _pickupOrder(BuildContext context) async {
    final success = await controller.pickupOrder(order.id);
    if (context.mounted) {
      if (success) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Order picked up successfully')),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Failed to pickup order: ${controller.state.errorMessage ?? 'Unknown error'}')),
        );
      }
    }
  }

  void _deliverOrder(BuildContext context) async {
    final notesCtrl = TextEditingController();
    final confirmed = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Deliver Order'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const Text('Add delivery notes (optional):'),
            const SizedBox(height: 12),
            TextField(
              controller: notesCtrl,
              decoration: const InputDecoration(
                hintText: 'Delivery notes...',
                border: OutlineInputBorder(),
              ),
              maxLines: 3,
            ),
          ],
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context, false),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.pop(context, true),
            child: const Text('Confirm Delivery'),
          ),
        ],
      ),
    );

    if (confirmed == true) {
      final success = await controller.deliverOrder(order.id, notes: notesCtrl.text.isEmpty ? null : notesCtrl.text);
      if (context.mounted) {
        if (success) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Order delivered successfully')),
          );
        } else {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Failed to deliver order: ${controller.state.errorMessage ?? 'Unknown error'}')),
          );
        }
      }
    }
  }

  void _showOrderDetails(BuildContext context, OrderDto order) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) => DraggableScrollableSheet(
        initialChildSize: 0.9,
        minChildSize: 0.5,
        maxChildSize: 0.95,
        expand: false,
        builder: (context, scrollController) => SingleChildScrollView(
          controller: scrollController,
          padding: const EdgeInsets.all(24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Center(
                child: Container(
                  width: 40,
                  height: 4,
                  margin: const EdgeInsets.only(bottom: 24),
                  decoration: BoxDecoration(
                    color: Colors.grey[300],
                    borderRadius: BorderRadius.circular(2),
                  ),
                ),
              ),
              Text(
                'Order Details',
                style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                      fontWeight: FontWeight.bold,
                    ),
              ),
              const SizedBox(height: 24),
              _DetailRow(label: 'Order Number', value: order.orderNumber),
              _DetailRow(label: 'Customer', value: order.customerName),
              _DetailRow(label: 'Phone', value: order.customerPhone),
              _DetailRow(label: 'Address', value: order.formattedAddress),
              _DetailRow(label: 'Status', value: order.status),
              _DetailRow(label: 'Subtotal', value: '\$${order.subtotal.toStringAsFixed(2)}'),
              _DetailRow(label: 'Tax', value: '\$${order.taxAmount.toStringAsFixed(2)}'),
              _DetailRow(label: 'Discount', value: '\$${order.discountAmount.toStringAsFixed(2)}'),
              _DetailRow(label: 'Total', value: '\$${order.totalAmount.toStringAsFixed(2)}'),
              if (order.deliveryNotes != null)
                _DetailRow(label: 'Notes', value: order.deliveryNotes!),
              if (order.items.isNotEmpty) ...[
                const SizedBox(height: 24),
                Text(
                  'Items',
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                        fontWeight: FontWeight.bold,
                      ),
                ),
                const SizedBox(height: 12),
                ...order.items.map((item) => Padding(
                      padding: const EdgeInsets.only(bottom: 8),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Expanded(
                            child: Text('${item.productName ?? 'Product ${item.productId}'} x${item.quantity}'),
                          ),
                          Text('\$${item.totalPrice.toStringAsFixed(2)}'),
                        ],
                      ),
                    )),
              ],
            ],
          ),
        ),
      ),
    );
  }
}

class _DetailRow extends StatelessWidget {
  const _DetailRow({required this.label, required this.value});

  final String label;
  final String value;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 100,
            child: Text(
              label,
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: Theme.of(context).colorScheme.onSurface.withOpacity(0.6),
                  ),
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    fontWeight: FontWeight.w500,
                  ),
            ),
          ),
        ],
      ),
    );
  }
}

