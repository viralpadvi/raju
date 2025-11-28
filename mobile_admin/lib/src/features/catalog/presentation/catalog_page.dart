import 'dart:typed_data';
import 'dart:ui';

import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:image_picker/image_picker.dart';
import 'package:intl/intl.dart';

import '../../../core/widgets/admin_drawer.dart';
import '../application/brand_controller.dart';
import '../application/category_controller.dart';
import '../application/product_controller.dart';
import '../domain/product_models.dart';

enum ViewMode { grid, list }

final viewModeProvider = StateProvider<ViewMode>((ref) => ViewMode.list);

class CatalogPage extends ConsumerWidget {
  const CatalogPage({super.key});

  static const routePath = '/catalog';
  static const routeName = 'catalog';

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final state = ref.watch(productControllerProvider);
    final controller = ref.read(productControllerProvider.notifier);
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
                  colors: [Color(0xFF10B981), Color(0xFF059669)],
                ),
                borderRadius: BorderRadius.circular(8),
              ),
              child: const Icon(Icons.inventory_2_rounded, color: Colors.white, size: 20),
            ),
            const SizedBox(width: 12),
            const Text('Catalog'),
          ],
        ),
        actions: [
          Consumer(
            builder: (context, ref, _) {
              final viewMode = ref.watch(viewModeProvider);
              return IconButton(
                icon: Icon(
                  viewMode == ViewMode.grid ? Icons.view_list_rounded : Icons.grid_view_rounded,
                ),
                onPressed: () {
                  ref.read(viewModeProvider.notifier).state =
                      viewMode == ViewMode.grid ? ViewMode.list : ViewMode.grid;
                },
                tooltip: viewMode == ViewMode.grid ? 'List view' : 'Grid view',
              );
            },
          ),
          if (state.drafts.isNotEmpty)
            Badge(
              label: Text('${state.drafts.length}'),
              child: IconButton(
                icon: const Icon(Icons.cloud_upload_rounded),
                onPressed: controller.syncDrafts,
                tooltip: 'Sync drafts',
              ),
            )
          else
            IconButton(
              icon: const Icon(Icons.sync_rounded),
              onPressed: controller.syncDrafts,
              tooltip: 'Sync drafts',
            ),
        ],
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () => _openProductWizardPage(context, controller),
        icon: const Icon(Icons.add_rounded),
        label: const Text('Product'),
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
            if (state.drafts.isNotEmpty)
              SliverToBoxAdapter(
                child: Padding(
                  padding: const EdgeInsets.fromLTRB(16, 16, 16, 8),
                  child: _DraftsBanner(drafts: state.drafts),
                ),
              ),
            if (state.products.isEmpty)
              SliverFillRemaining(
                hasScrollBody: false,
                child: Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(
                        Icons.inventory_2_outlined,
                        size: 80,
                        color: theme.colorScheme.outline,
                      ),
                      const SizedBox(height: 16),
                      Text(
                        'No products yet',
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
              Consumer(
                builder: (context, ref, _) {
                  final viewMode = ref.watch(viewModeProvider);
                  if (viewMode == ViewMode.grid) {
                    return SliverPadding(
                      padding: const EdgeInsets.all(16),
                      sliver: SliverGrid(
                        gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                          crossAxisCount: 2,
                          childAspectRatio: 0.75,
                          crossAxisSpacing: 12,
                          mainAxisSpacing: 12,
                        ),
                        delegate: SliverChildBuilderDelegate(
                          (context, index) => _ProductCard(product: state.products[index]),
                          childCount: state.products.length,
                        ),
                      ),
                    );
                  } else {
                    return SliverPadding(
                      padding: const EdgeInsets.all(16),
                      sliver: SliverList(
                        delegate: SliverChildBuilderDelegate(
                          (context, index) => Padding(
                            padding: const EdgeInsets.only(bottom: 12),
                            child: _ProductTile(product: state.products[index]),
                          ),
                          childCount: state.products.length,
                        ),
                      ),
                    );
                  }
                },
              ),
          ],
        ),
      ),
    );
  }

}

Future<void> _showDeleteDialog(
  BuildContext context,
  ProductController controller,
  ProductDto product,
) async {
  final confirm = await showDialog<bool>(
    context: context,
    builder: (context) => AlertDialog(
      title: const Text('Delete Product'),
      content: Text('Are you sure you want to delete "${product.name}"?'),
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
    await controller.deleteProduct(product.id);
    if (context.mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Product deleted')),
      );
    }
  }
}

Future<void> _openProductWizardPage(
  BuildContext context,
  ProductController controller, {
  ProductDto? product,
}) {
  return Navigator.of(context).push(
    MaterialPageRoute(
      fullscreenDialog: true,
      builder: (_) => AddProductPage(controller: controller, product: product),
    ),
  );
}

class _ProductCard extends ConsumerWidget {
  const _ProductCard({required this.product});

  final ProductDto product;

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final theme = Theme.of(context);
    final controller = ref.read(productControllerProvider.notifier);

    return GestureDetector(
      onTap: () => _openProductWizardPage(context, controller, product: product),
      child: Container(
        decoration: BoxDecoration(
          color: theme.colorScheme.surfaceContainerHighest.withOpacity(0.3),
          borderRadius: BorderRadius.circular(16),
          border: Border.all(
            color: theme.colorScheme.outline.withOpacity(0.1),
          ),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Product Image/Icon Section
            Container(
              height: 120,
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF10B981), Color(0xFF059669)],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: const BorderRadius.vertical(top: Radius.circular(16)),
              ),
              child: Stack(
                children: [
                  Center(
                    child: Icon(
                      Icons.inventory_2_rounded,
                      color: Colors.white.withOpacity(0.8),
                      size: 48,
                    ),
                  ),
                  if (product.isFeatured)
                    Positioned(
                      top: 8,
                      right: 8,
                      child: Container(
                        padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                        decoration: BoxDecoration(
                          color: Colors.amber,
                          borderRadius: BorderRadius.circular(4),
                        ),
                        child: const Text(
                          'FEATURED',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 8,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                  Positioned(
                    top: 8,
                    left: 8,
                    child: PopupMenuButton(
                      icon: Container(
                        padding: const EdgeInsets.all(4),
                        decoration: BoxDecoration(
                          color: Colors.white.withOpacity(0.2),
                          borderRadius: BorderRadius.circular(4),
                        ),
                        child: const Icon(Icons.more_vert_rounded, color: Colors.white, size: 16),
                      ),
                      itemBuilder: (context) => [
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
                            () => _openProductWizardPage(context, controller, product: product),
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
                            () => _showDeleteDialog(context, controller, product),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            // Product Info Section
            Expanded(
              child: Padding(
                padding: const EdgeInsets.all(12),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      product.name,
                      style: theme.textTheme.titleSmall?.copyWith(
                        fontWeight: FontWeight.w600,
                      ),
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      'SKU: ${product.sku}',
                      style: theme.textTheme.bodySmall?.copyWith(
                        color: theme.colorScheme.onSurfaceVariant,
                        fontSize: 10,
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                    const Spacer(),
                    if (product.category != null || product.brand != null)
                      Padding(
                        padding: const EdgeInsets.only(bottom: 8),
                        child: Wrap(
                          spacing: 4,
                          runSpacing: 4,
                          children: [
                            if (product.category != null)
                              Container(
                                padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                decoration: BoxDecoration(
                                  color: theme.colorScheme.secondaryContainer,
                                  borderRadius: BorderRadius.circular(4),
                                ),
                                child: Text(
                                  product.category!.name,
                                  style: theme.textTheme.bodySmall?.copyWith(
                                    color: theme.colorScheme.onSecondaryContainer,
                                    fontSize: 9,
                                  ),
                                ),
                              ),
                            if (product.brand != null)
                              Container(
                                padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                decoration: BoxDecoration(
                                  color: theme.colorScheme.tertiaryContainer,
                                  borderRadius: BorderRadius.circular(4),
                                ),
                                child: Text(
                                  product.brand!.name,
                                  style: theme.textTheme.bodySmall?.copyWith(
                                    color: theme.colorScheme.onTertiaryContainer,
                                    fontSize: 9,
                                  ),
                                ),
                              ),
                          ],
                        ),
                      ),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      crossAxisAlignment: CrossAxisAlignment.end,
                      children: [
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                '₹${product.price.toStringAsFixed(2)}',
                                style: theme.textTheme.titleMedium?.copyWith(
                                  fontWeight: FontWeight.bold,
                                  color: theme.colorScheme.primary,
                                ),
                              ),
                              const SizedBox(height: 4),
                              Container(
                                padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                decoration: BoxDecoration(
                                  color: product.stockQuantity > 0
                                      ? const Color(0xFF10B981).withOpacity(0.1)
                                      : const Color(0xFFEF4444).withOpacity(0.1),
                                  borderRadius: BorderRadius.circular(4),
                                ),
                                child: Text(
                                  'Stock: ${product.stockQuantity}',
                                  style: theme.textTheme.bodySmall?.copyWith(
                                    color: product.stockQuantity > 0
                                        ? const Color(0xFF10B981)
                                        : const Color(0xFFEF4444),
                                    fontWeight: FontWeight.w500,
                                    fontSize: 10,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _ProductTile extends ConsumerWidget {
  const _ProductTile({required this.product});

  final ProductDto product;

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final theme = Theme.of(context);
    final controller = ref.read(productControllerProvider.notifier);
    
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
            gradient: const LinearGradient(
              colors: [Color(0xFF10B981), Color(0xFF059669)],
            ),
            borderRadius: BorderRadius.circular(12),
          ),
          child: const Icon(Icons.inventory_2_rounded, color: Colors.white, size: 20),
        ),
        title: Text(
          product.name,
          style: theme.textTheme.titleMedium?.copyWith(
            fontWeight: FontWeight.w600,
          ),
        ),
        subtitle: Padding(
          padding: const EdgeInsets.only(top: 4),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'SKU: ${product.sku}',
                style: theme.textTheme.bodySmall,
              ),
              if (product.category != null || product.brand != null)
                Padding(
                  padding: const EdgeInsets.only(top: 4),
                  child: Wrap(
                    spacing: 8,
                    children: [
                      if (product.category != null)
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                          decoration: BoxDecoration(
                            color: theme.colorScheme.secondaryContainer,
                            borderRadius: BorderRadius.circular(6),
                          ),
                          child: Text(
                            product.category!.name,
                            style: theme.textTheme.bodySmall?.copyWith(
                              color: theme.colorScheme.onSecondaryContainer,
                              fontSize: 10,
                            ),
                          ),
                        ),
                      if (product.brand != null)
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                          decoration: BoxDecoration(
                            color: theme.colorScheme.tertiaryContainer,
                            borderRadius: BorderRadius.circular(6),
                          ),
                          child: Text(
                            product.brand!.name,
                            style: theme.textTheme.bodySmall?.copyWith(
                              color: theme.colorScheme.onTertiaryContainer,
                              fontSize: 10,
                            ),
                          ),
                        ),
                    ],
                  ),
                ),
            ],
          ),
        ),
        trailing: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.end,
              children: [
                Text(
                  '₹${product.price.toStringAsFixed(2)}',
                  style: theme.textTheme.titleMedium?.copyWith(
                    fontWeight: FontWeight.bold,
                    color: theme.colorScheme.primary,
                  ),
                ),
                const SizedBox(height: 4),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                  decoration: BoxDecoration(
                    color: product.stockQuantity > 0
                        ? const Color(0xFF10B981).withOpacity(0.1)
                        : const Color(0xFFEF4444).withOpacity(0.1),
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: Text(
                    'Stock: ${product.stockQuantity}',
                    style: theme.textTheme.bodySmall?.copyWith(
                      color: product.stockQuantity > 0
                          ? const Color(0xFF10B981)
                          : const Color(0xFFEF4444),
                      fontWeight: FontWeight.w500,
                      fontSize: 11,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(width: 8),
            PopupMenuButton(
              itemBuilder: (context) => [
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
                    () => _openProductWizardPage(context, controller, product: product),
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
                    () => _showDeleteDialog(context, controller, product),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

class _DraftsBanner extends StatelessWidget {
  const _DraftsBanner({required this.drafts});

  final List<ProductDraft> drafts;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    return Container(
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
              '${drafts.length} product(s) waiting for sync.',
              style: theme.textTheme.bodyMedium?.copyWith(
                color: const Color(0xFFD97706),
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class AddProductPage extends ConsumerStatefulWidget {
  const AddProductPage({required this.controller, this.product, super.key});

  final ProductController controller;
  final ProductDto? product;

  @override
  ConsumerState<AddProductPage> createState() => _AddProductPageState();
}

class _AddProductPageState extends ConsumerState<AddProductPage> {
  final _basicKey = GlobalKey<FormState>();
  final _pricingKey = GlobalKey<FormState>();
  final _seoKey = GlobalKey<FormState>();

  final _nameCtrl = TextEditingController();
  final _descriptionCtrl = TextEditingController();
  final _skuCtrl = TextEditingController();
  final _barcodeCtrl = TextEditingController();
  final _stockCtrl = TextEditingController(text: '0');
  final _minStockCtrl = TextEditingController(text: '0');
  final _weightCtrl = TextEditingController();
  final _dimensionsCtrl = TextEditingController();
  final _colorCtrl = TextEditingController();
  final _sizeCtrl = TextEditingController();
  final _priceCtrl = TextEditingController();
  final _comparePriceCtrl = TextEditingController();
  final _costPriceCtrl = TextEditingController();
  final _salePriceCtrl = TextEditingController();
  final _gstCtrl = TextEditingController();
  final _hsnCtrl = TextEditingController();
  final _discountValueCtrl = TextEditingController();
  final _seoTitleCtrl = TextEditingController();
  final _seoDescriptionCtrl = TextEditingController();
  final _seoKeywordsCtrl = TextEditingController();
  final _sortOrderCtrl = TextEditingController();

  int _currentStep = 0;
  int? _categoryId;
  int? _brandId;
  bool _isActive = true;
  bool _isFeatured = false;
  String _discountType = 'none';
  DateTime? _discountStart;
  DateTime? _discountEnd;
  Map<String, dynamic>? _specifications;
  final ImagePicker _picker = ImagePicker();
  List<ProductImageUpload> _images = [];

  @override
  void initState() {
    super.initState();
    final product = widget.product;
    if (product != null) {
      _nameCtrl.text = product.name;
      _descriptionCtrl.text = product.description ?? '';
      _skuCtrl.text = product.sku;
      _barcodeCtrl.text = product.barcode ?? '';
      _stockCtrl.text = product.stockQuantity.toString();
      _minStockCtrl.text = (product.minStockLevel ?? 0).toString();
      _weightCtrl.text =
          product.weight != null ? product.weight!.toString() : '';
      _dimensionsCtrl.text = product.dimensions ?? '';
      _colorCtrl.text = product.color ?? '';
      _sizeCtrl.text = product.size ?? '';
      _priceCtrl.text = product.price.toString();
      _salePriceCtrl.text = product.salePrice != null ? product.salePrice!.toString() : '';
      _sortOrderCtrl.text = product.sortOrder != null ? product.sortOrder!.toString() : '';
      _specifications = product.specifications;
      _comparePriceCtrl.text =
          product.compareAtPrice != null ? product.compareAtPrice!.toString() : '';
      _costPriceCtrl.text =
          product.costPrice != null ? product.costPrice!.toString() : '';
      _gstCtrl.text = product.gstRate != null ? product.gstRate!.toString() : '';
      _hsnCtrl.text = product.hsnCode ?? '';
      _discountValueCtrl.text =
          product.discountValue != null ? product.discountValue!.toString() : '';
      _discountType = product.discountType == 'percentage' 
          ? 'percent' 
          : (product.discountType ?? 'none');
      _discountStart = product.discountStartAt;
      _discountEnd = product.discountEndAt;
      _seoTitleCtrl.text = product.seoTitle ?? '';
      _seoDescriptionCtrl.text = product.seoDescription ?? '';
      _seoKeywordsCtrl.text = product.seoKeywords ?? '';
      _categoryId = product.categoryId;
      _brandId = product.brandId;
      _isActive = product.isActive;
      _isFeatured = product.isFeatured;
    }

    WidgetsBinding.instance.addPostFrameCallback((_) {
      final brandController = ref.read(brandControllerProvider.notifier);
      final categoryController = ref.read(categoryControllerProvider.notifier);
      if (ref.read(brandControllerProvider).brands.isEmpty) {
        brandController.refresh();
      }
      if (ref.read(categoryControllerProvider).categories.isEmpty) {
        categoryController.refresh();
      }
    });
  }

  @override
  void dispose() {
    _nameCtrl.dispose();
    _descriptionCtrl.dispose();
    _skuCtrl.dispose();
    _barcodeCtrl.dispose();
    _stockCtrl.dispose();
    _minStockCtrl.dispose();
    _weightCtrl.dispose();
    _dimensionsCtrl.dispose();
    _colorCtrl.dispose();
    _sizeCtrl.dispose();
    _priceCtrl.dispose();
    _salePriceCtrl.dispose();
    _sortOrderCtrl.dispose();
    _comparePriceCtrl.dispose();
    _costPriceCtrl.dispose();
    _gstCtrl.dispose();
    _hsnCtrl.dispose();
    _discountValueCtrl.dispose();
    _seoTitleCtrl.dispose();
    _seoDescriptionCtrl.dispose();
    _seoKeywordsCtrl.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final brandsState = ref.watch(brandControllerProvider);
    final categoriesState = ref.watch(categoryControllerProvider);

    final steps = [
      Step(
        title: const Text('Basics'),
        state: _currentStep > 0 ? StepState.complete : StepState.indexed,
        isActive: _currentStep >= 0,
        content: _BasicInfoStep(
          formKey: _basicKey,
          nameCtrl: _nameCtrl,
          descriptionCtrl: _descriptionCtrl,
          brandId: _brandId,
          categoryId: _categoryId,
          skuCtrl: _skuCtrl,
          barcodeCtrl: _barcodeCtrl,
          stockCtrl: _stockCtrl,
          minStockCtrl: _minStockCtrl,
          weightCtrl: _weightCtrl,
          dimensionsCtrl: _dimensionsCtrl,
          colorCtrl: _colorCtrl,
          sizeCtrl: _sizeCtrl,
          sortOrderCtrl: _sortOrderCtrl,
          isActive: _isActive,
          isFeatured: _isFeatured,
          onBrandChanged: (value) => setState(() => _brandId = value),
          onCategoryChanged: (value) => setState(() => _categoryId = value),
          onActiveChanged: (value) => setState(() => _isActive = value),
          onFeaturedChanged: (value) => setState(() => _isFeatured = value),
          brandsState: brandsState,
          categoriesState: categoriesState,
        ),
      ),
      Step(
        title: const Text('Pricing'),
        state: _currentStep > 1 ? StepState.complete : StepState.indexed,
        isActive: _currentStep >= 1,
        content: _PricingStep(
          formKey: _pricingKey,
          priceCtrl: _priceCtrl,
          comparePriceCtrl: _comparePriceCtrl,
          costPriceCtrl: _costPriceCtrl,
          salePriceCtrl: _salePriceCtrl,
          gstCtrl: _gstCtrl,
          hsnCtrl: _hsnCtrl,
          discountValueCtrl: _discountValueCtrl,
          discountType: _discountType,
          onDiscountTypeChanged: (value) => setState(() => _discountType = value),
          discountStart: _discountStart,
          discountEnd: _discountEnd,
          onPickDate: _pickDate,
        ),
      ),
      Step(
        title: const Text('SEO'),
        state: _currentStep > 2 ? StepState.complete : StepState.indexed,
        isActive: _currentStep >= 2,
        content: _SeoStep(
          formKey: _seoKey,
          seoTitleCtrl: _seoTitleCtrl,
          seoDescriptionCtrl: _seoDescriptionCtrl,
          seoKeywordsCtrl: _seoKeywordsCtrl,
        ),
      ),
      Step(
        title: const Text('Images'),
        state: StepState.indexed,
        isActive: _currentStep >= 3,
        content: _ImagesStep(
          images: _images,
          onPickImages: _pickImages,
          onRemoveImage: (index) {
            setState(() {
              _images.removeAt(index);
            });
          },
        ),
      ),
    ];

    final theme = Theme.of(context);
    final isEditing = widget.product != null;
    return Theme(
      data: theme.copyWith(
        textTheme: GoogleFonts.manropeTextTheme(theme.textTheme),
        colorScheme: theme.colorScheme.copyWith(primary: const Color(0xFF5B5FEF)),
        canvasColor: Colors.transparent,
      ),
      child: Scaffold(
        backgroundColor: Colors.transparent,
        appBar: AppBar(
          backgroundColor: Colors.white.withOpacity(0.5),
          elevation: 0,
          title: Text(isEditing ? 'Update Product' : 'Add Product'),
        ),
        body: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(
              colors: [Color(0xFFF6F7FB), Color(0xFFE9ECFF)],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
          ),
          child: SafeArea(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    isEditing ? 'Refine your catalog item' : 'Create a new masterpiece',
                    style: theme.textTheme.headlineSmall?.copyWith(
                      fontWeight: FontWeight.w700,
                      color: const Color(0xFF1F1F39),
                    ),
                  ),
                  const SizedBox(height: 6),
                  Text(
                    'Complete each step to publish a polished product entry.',
                    style: theme.textTheme.bodyMedium?.copyWith(
                      color: const Color(0xFF6B7280),
                    ),
                  ),
                  const SizedBox(height: 16),
                  Expanded(
                    child: _GlassContainer(
                      padding: EdgeInsets.zero,
                      child: Stepper(
                          type: StepperType.horizontal,
                          elevation: 0,
                          currentStep: _currentStep,
                          steps: steps,
                          onStepTapped: (index) {
                            if (index <= _currentStep && _validateStep(index)) {
                              setState(() => _currentStep = index);
                            }
                          },
                          onStepContinue: () {
                            if (!_validateStep(_currentStep)) return;
                            if (_currentStep == steps.length - 1) {
                              _submit();
                            } else {
                              setState(() => _currentStep += 1);
                            }
                          },
                          onStepCancel: () {
                            if (_currentStep == 0) {
                              Navigator.of(context).maybePop();
                            } else {
                              setState(() => _currentStep -= 1);
                            }
                          },
                          controlsBuilder: (context, details) {
                            final isLast = _currentStep == steps.length - 1;
                            final primaryText =
                                isLast ? (isEditing ? 'Save Product' : 'Create Product') : 'Next Step';
                            return Padding(
                              padding: const EdgeInsets.only(top: 16),
                              child: Row(
                                children: [
                                  if (_currentStep > 0)
                                    OutlinedButton(
                                      style: OutlinedButton.styleFrom(
                                        foregroundColor: const Color(0xFF4F46E5),
                                        side: const BorderSide(color: Color(0xFFCBD5F5)),
                                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                                      ),
                                      onPressed: details.onStepCancel,
                                      child: const Text('Back'),
                                    ),
                                  const SizedBox(width: 12),
                                  Expanded(
                                    child: ElevatedButton(
                                      style: ElevatedButton.styleFrom(
                                        padding: const EdgeInsets.symmetric(vertical: 16),
                                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
                                        backgroundColor: const Color(0xFF4F46E5),
                                      ),
                                      onPressed: details.onStepContinue,
                                      child: Text(primaryText),
                                    ),
                                  ),
                                ],
                              ),
                            );
                          },
                        ),
                      ),
                    ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  bool _validateStep(int step) {
    switch (step) {
      case 0:
        return _basicKey.currentState?.validate() ?? false;
      case 1:
        return _pricingKey.currentState?.validate() ?? false;
      case 2:
        return _seoKey.currentState?.validate() ?? true;
      default:
        return true;
    }
  }

  Future<void> _pickDate(bool isStart) async {
    final context = this.context;
    final initial = isStart ? _discountStart ?? DateTime.now() : _discountEnd ?? DateTime.now();
    final picked = await showDatePicker(
      context: context,
      initialDate: initial,
      firstDate: DateTime(2000),
      lastDate: DateTime(2100),
    );
    if (picked != null) {
      setState(() {
        if (isStart) {
          _discountStart = picked;
        } else {
          _discountEnd = picked;
        }
      });
    }
  }

  Future<void> _pickImages() async {
    final result = await _picker.pickMultiImage(imageQuality: 90);
    if (result.isEmpty) return;
    final previews = <ProductImageUpload>[];
    for (final file in result) {
      final bytes = await file.readAsBytes();
      final fileName = file.name.isNotEmpty ? file.name : file.path.split('/').last;
      previews.add(ProductImageUpload(name: fileName, bytes: bytes));
    }
    setState(() {
      _images = [..._images, ...previews];
    });
  }

  Future<void> _submit() async {
    if (!_basicKey.currentState!.validate() ||
        !_pricingKey.currentState!.validate() ||
        !(_seoKey.currentState?.validate() ?? true)) {
      return;
    }

    final payload = ProductPayload(
      name: _nameCtrl.text.trim(),
      description: _descriptionCtrl.text.trim().isEmpty ? null : _descriptionCtrl.text.trim(),
      sku: _skuCtrl.text.trim(),
      price: double.tryParse(_priceCtrl.text) ?? 0,
      stockQuantity: int.tryParse(_stockCtrl.text) ?? 0,
      categoryId: _categoryId ?? 0,
      brandId: _brandId,
      barcode: _barcodeCtrl.text.trim().isEmpty ? null : _barcodeCtrl.text.trim(),
      minStockLevel: int.tryParse(_minStockCtrl.text),
      weight: double.tryParse(_weightCtrl.text),
      dimensions: _dimensionsCtrl.text.trim().isEmpty ? null : _dimensionsCtrl.text.trim(),
      color: _colorCtrl.text.trim().isEmpty ? null : _colorCtrl.text.trim(),
      size: _sizeCtrl.text.trim().isEmpty ? null : _sizeCtrl.text.trim(),
      specifications: _specifications,
      compareAtPrice: double.tryParse(_comparePriceCtrl.text),
      costPrice: double.tryParse(_costPriceCtrl.text),
      salePrice: double.tryParse(_salePriceCtrl.text),
      gstRate: double.tryParse(_gstCtrl.text),
      hsnCode: _hsnCtrl.text.trim().isEmpty ? null : _hsnCtrl.text.trim(),
      discountValue: double.tryParse(_discountValueCtrl.text),
      discountType: _discountType == 'none' 
          ? null 
          : (_discountType == 'percent' ? 'percentage' : _discountType),
      discountStartAt: _discountStart,
      discountEndAt: _discountEnd,
      seoTitle: _seoTitleCtrl.text.trim().isEmpty ? null : _seoTitleCtrl.text.trim(),
      seoDescription:
          _seoDescriptionCtrl.text.trim().isEmpty ? null : _seoDescriptionCtrl.text.trim(),
      seoKeywords: _seoKeywordsCtrl.text.trim().isEmpty ? null : _seoKeywordsCtrl.text.trim(),
      isActive: _isActive,
      isFeatured: _isFeatured,
      sortOrder: int.tryParse(_sortOrderCtrl.text),
    );

    if (widget.product == null) {
      await widget.controller.createProduct(
        payload,
        images: _images.isEmpty ? null : _images,
      );
    } else {
      await widget.controller.updateProduct(widget.product!.id, payload);
    }

    if (mounted) {
      Navigator.of(context).pop();
    }
  }
}

class _BasicInfoStep extends StatelessWidget {
  const _BasicInfoStep({
    required this.formKey,
    required this.nameCtrl,
    required this.descriptionCtrl,
    required this.brandId,
    required this.categoryId,
    required this.skuCtrl,
    required this.barcodeCtrl,
    required this.stockCtrl,
    required this.minStockCtrl,
    required this.weightCtrl,
    required this.dimensionsCtrl,
    required this.colorCtrl,
    required this.sizeCtrl,
    required this.sortOrderCtrl,
    required this.isActive,
    required this.isFeatured,
    required this.onBrandChanged,
    required this.onCategoryChanged,
    required this.onActiveChanged,
    required this.onFeaturedChanged,
    required this.brandsState,
    required this.categoriesState,
  });

  final GlobalKey<FormState> formKey;
  final TextEditingController nameCtrl;
  final TextEditingController descriptionCtrl;
  final TextEditingController skuCtrl;
  final TextEditingController barcodeCtrl;
  final TextEditingController stockCtrl;
  final TextEditingController minStockCtrl;
  final TextEditingController weightCtrl;
  final TextEditingController dimensionsCtrl;
  final TextEditingController colorCtrl;
  final TextEditingController sizeCtrl;
  final TextEditingController sortOrderCtrl;
  final bool isActive;
  final bool isFeatured;
  final int? brandId;
  final int? categoryId;
  final ValueChanged<int?> onBrandChanged;
  final ValueChanged<int?> onCategoryChanged;
  final ValueChanged<bool> onActiveChanged;
  final ValueChanged<bool> onFeaturedChanged;
  final BrandState brandsState;
  final CategoryState categoriesState;

  @override
  Widget build(BuildContext context) {
    return Form(
      key: formKey,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          _ResponsiveColumns(
            left: _CardSection(
              title: 'Basic Information',
              child: Column(
                children: [
                  TextFormField(
                    controller: nameCtrl,
                    decoration: const InputDecoration(labelText: 'Product Name *'),
                    validator: (value) => value == null || value.isEmpty ? 'Required' : null,
                  ),
                  const SizedBox(height: 12),
                  TextFormField(
                    controller: descriptionCtrl,
                    decoration: const InputDecoration(labelText: 'Description'),
                    maxLines: 4,
                  ),
                ],
              ),
            ),
            right: _CardSection(
              title: 'Organization',
              child: Column(
                children: [
                  DropdownButtonFormField<int>(
                    value: categoryId,
                    decoration: const InputDecoration(labelText: 'Category *'),
                    items: categoriesState.categories
                        .map(
                          (cat) => DropdownMenuItem<int>(
                            value: cat.id,
                            child: Text(cat.name),
                          ),
                        )
                        .toList(),
                    onChanged: onCategoryChanged,
                    validator: (value) => value == null ? 'Please select category' : null,
                  ),
                  const SizedBox(height: 12),
                  DropdownButtonFormField<int?>(
                    value: brandId,
                    decoration: const InputDecoration(labelText: 'Brand'),
                    items: [
                      const DropdownMenuItem<int?>(value: null, child: Text('None')),
                      ...brandsState.brands
                          .map(
                            (brand) => DropdownMenuItem<int?>(
                              value: brand.id,
                              child: Text(brand.name),
                            ),
                          )
                          .toList(),
                    ],
                    onChanged: onBrandChanged,
                  ),
                  const SizedBox(height: 12),
                  Row(
                    children: [
                      Expanded(
                        child: TextFormField(
                          controller: skuCtrl,
                          decoration: const InputDecoration(labelText: 'SKU *'),
                          validator: (value) => value == null || value.isEmpty ? 'Required' : null,
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: TextFormField(
                          controller: barcodeCtrl,
                          decoration: const InputDecoration(labelText: 'Barcode'),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  Row(
                    children: [
                      Expanded(
                        child: TextFormField(
                          controller: stockCtrl,
                          decoration: const InputDecoration(labelText: 'Stock *'),
                          keyboardType: TextInputType.number,
                          validator: (value) => value == null || value.isEmpty ? 'Required' : null,
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: TextFormField(
                          controller: minStockCtrl,
                          decoration: const InputDecoration(labelText: 'Min. Stock'),
                          keyboardType: TextInputType.number,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  Row(
                    children: [
                      Expanded(
                        child: TextFormField(
                          controller: weightCtrl,
                          decoration: const InputDecoration(labelText: 'Weight (kg)'),
                          keyboardType: TextInputType.number,
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: TextFormField(
                          controller: dimensionsCtrl,
                          decoration: const InputDecoration(labelText: 'Dimensions'),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  Row(
                    children: [
                      Expanded(
                        child: TextFormField(
                          controller: colorCtrl,
                          decoration: const InputDecoration(labelText: 'Color'),
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: TextFormField(
                          controller: sizeCtrl,
                          decoration: const InputDecoration(labelText: 'Size'),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  TextFormField(
                    controller: sortOrderCtrl,
                    decoration: const InputDecoration(labelText: 'Sort Order'),
                    keyboardType: TextInputType.number,
                  ),
                  const SizedBox(height: 12),
                  Row(
                    children: [
                      Expanded(
                        child: SwitchListTile.adaptive(
                          contentPadding: EdgeInsets.zero,
                          title: const Text('Active'),
                          value: isActive,
                          onChanged: onActiveChanged,
                        ),
                      ),
                      Expanded(
                        child: SwitchListTile.adaptive(
                          contentPadding: EdgeInsets.zero,
                          title: const Text('Featured'),
                          value: isFeatured,
                          onChanged: onFeaturedChanged,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _PricingStep extends StatelessWidget {
  const _PricingStep({
    required this.formKey,
    required this.priceCtrl,
    required this.comparePriceCtrl,
    required this.costPriceCtrl,
    required this.salePriceCtrl,
    required this.gstCtrl,
    required this.hsnCtrl,
    required this.discountValueCtrl,
    required this.discountType,
    required this.onDiscountTypeChanged,
    required this.discountStart,
    required this.discountEnd,
    required this.onPickDate,
  });

  final GlobalKey<FormState> formKey;
  final TextEditingController priceCtrl;
  final TextEditingController comparePriceCtrl;
  final TextEditingController costPriceCtrl;
  final TextEditingController salePriceCtrl;
  final TextEditingController gstCtrl;
  final TextEditingController hsnCtrl;
  final TextEditingController discountValueCtrl;
  final String discountType;
  final ValueChanged<String> onDiscountTypeChanged;
  final DateTime? discountStart;
  final DateTime? discountEnd;
  final Future<void> Function(bool isStart) onPickDate;

  @override
  Widget build(BuildContext context) {
    final dateFormat = DateFormat('dd MMM yyyy');
    return Form(
      key: formKey,
      child: _CardSection(
        title: 'Pricing & Discount',
        child: Column(
          children: [
            Row(
              children: [
                Expanded(
                  child: TextFormField(
                    controller: priceCtrl,
                    decoration: const InputDecoration(labelText: 'Price *'),
                    keyboardType: TextInputType.number,
                    validator: (value) => value == null || value.isEmpty ? 'Required' : null,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: TextFormField(
                    controller: comparePriceCtrl,
                    decoration: const InputDecoration(labelText: 'Compare at Price'),
                    keyboardType: TextInputType.number,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: TextFormField(
                    controller: costPriceCtrl,
                    decoration: const InputDecoration(labelText: 'Cost Price'),
                    keyboardType: TextInputType.number,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: salePriceCtrl,
              decoration: const InputDecoration(labelText: 'Sale Price'),
              keyboardType: TextInputType.number,
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: TextFormField(
                    controller: gstCtrl,
                    decoration: const InputDecoration(labelText: 'GST Rate (%)'),
                    keyboardType: TextInputType.number,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: TextFormField(
                    controller: hsnCtrl,
                    decoration: const InputDecoration(labelText: 'HSN Code'),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: DropdownButtonFormField<String>(
                    value: discountType,
                    decoration: const InputDecoration(labelText: 'Discount Type'),
                    items: const [
                      DropdownMenuItem(value: 'none', child: Text('None')),
                      DropdownMenuItem(value: 'percent', child: Text('Percent')),
                      DropdownMenuItem(value: 'fixed', child: Text('Fixed Amount')),
                    ],
                    onChanged: (value) {
                      if (value != null) onDiscountTypeChanged(value);
                    },
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: TextFormField(
                    controller: discountValueCtrl,
                    decoration: const InputDecoration(labelText: 'Discount Value'),
                    keyboardType: TextInputType.number,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: _DateField(
                    label: 'Discount Start',
                    value: discountStart == null ? '' : dateFormat.format(discountStart!),
                    onTap: () => onPickDate(true),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: _DateField(
                    label: 'Discount End',
                    value: discountEnd == null ? '' : dateFormat.format(discountEnd!),
                    onTap: () => onPickDate(false),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

class _SeoStep extends StatelessWidget {
  const _SeoStep({
    required this.formKey,
    required this.seoTitleCtrl,
    required this.seoDescriptionCtrl,
    required this.seoKeywordsCtrl,
  });

  final GlobalKey<FormState> formKey;
  final TextEditingController seoTitleCtrl;
  final TextEditingController seoDescriptionCtrl;
  final TextEditingController seoKeywordsCtrl;

  @override
  Widget build(BuildContext context) {
    return Form(
      key: formKey,
      child: _CardSection(
        title: 'SEO',
        child: Column(
          children: [
            TextFormField(
              controller: seoTitleCtrl,
              decoration: const InputDecoration(labelText: 'SEO Title'),
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: seoDescriptionCtrl,
              decoration: const InputDecoration(labelText: 'SEO Description'),
              maxLines: 3,
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: seoKeywordsCtrl,
              decoration:
                  const InputDecoration(labelText: 'SEO Keywords (comma separated)'),
            ),
          ],
        ),
      ),
    );
  }
}

class _ImagesStep extends StatelessWidget {
  const _ImagesStep({
    required this.images,
    required this.onPickImages,
    required this.onRemoveImage,
  });

  final List<ProductImageUpload> images;
  final VoidCallback onPickImages;
  final ValueChanged<int> onRemoveImage;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    return _CardSection(
      title: 'Product Images',
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          GestureDetector(
            onTap: onPickImages,
            child: Container(
              height: 170,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(20),
                border: Border.all(
                  color: Colors.white.withOpacity(0.4),
                ),
                gradient: LinearGradient(
                  colors: [
                    Colors.white.withOpacity(0.2),
                    Colors.white.withOpacity(0.05),
                  ],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
              ),
              child: Center(
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(Icons.cloud_upload_outlined, size: 40, color: theme.colorScheme.primary),
                    const SizedBox(height: 8),
                    Text(
                      'Click to upload or drag & drop\nPNG, JPG, GIF up to 2MB each',
                      style: theme.textTheme.bodyMedium?.copyWith(color: theme.colorScheme.onSurface),
                      textAlign: TextAlign.center,
                    ),
                  ],
                ),
              ),
            ),
          ),
          if (images.isNotEmpty) ...[
            const SizedBox(height: 16),
            Wrap(
              spacing: 12,
              runSpacing: 12,
              children: List.generate(
                images.length,
                (index) => Stack(
                  children: [
                    ClipRRect(
                      borderRadius: BorderRadius.circular(16),
                      child: Image.memory(
                        images[index].bytes,
                        width: 110,
                        height: 110,
                        fit: BoxFit.cover,
                      ),
                    ),
                    Positioned(
                      top: 6,
                      right: 6,
                      child: GestureDetector(
                        onTap: () => onRemoveImage(index),
                        child: Container(
                          decoration: BoxDecoration(
                            color: Colors.black.withOpacity(0.55),
                            borderRadius: BorderRadius.circular(20),
                          ),
                          padding: const EdgeInsets.all(4),
                          child: const Icon(Icons.close, size: 14, color: Colors.white),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ],
      ),
    );
  }
}

class _CardSection extends StatelessWidget {
  const _CardSection({required this.title, required this.child});

  final String title;
  final Widget child;

  @override
  Widget build(BuildContext context) {
    final theme = Theme.of(context);
    return _GlassContainer(
      padding: const EdgeInsets.all(24),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            title,
            style: theme.textTheme.titleMedium?.copyWith(fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 16),
          child,
        ],
      ),
    );
  }
}

class _ResponsiveColumns extends StatelessWidget {
  const _ResponsiveColumns({required this.left, required this.right});

  final Widget left;
  final Widget right;

  @override
  Widget build(BuildContext context) {
    final isWide = MediaQuery.of(context).size.width > 900;
    if (isWide) {
      return Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Expanded(child: left),
          const SizedBox(width: 16),
          Expanded(child: right),
        ],
      );
    }
    return Column(
      children: [
        left,
        const SizedBox(height: 16),
        right,
      ],
    );
  }
}

class _DateField extends StatelessWidget {
  const _DateField({
    required this.label,
    required this.value,
    required this.onTap,
  });

  final String label;
  final String value;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: InputDecorator(
        decoration: InputDecoration(
          labelText: label,
          suffixIcon: const Icon(Icons.calendar_today_rounded, size: 18),
        ),
        child: Text(
          value.isEmpty ? 'Select date' : value,
          style: Theme.of(context).textTheme.bodyMedium,
        ),
      ),
    );
  }
}

class _GlassContainer extends StatelessWidget {
  const _GlassContainer({required this.child, this.padding = const EdgeInsets.all(16)});

  final Widget child;
  final EdgeInsets padding;

  @override
  Widget build(BuildContext context) {
    return ClipRRect(
      borderRadius: BorderRadius.circular(30),
      child: BackdropFilter(
        filter: ImageFilter.blur(sigmaX: 20, sigmaY: 20),
        child: Container(
          padding: padding,
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(30),
            border: Border.all(color: Colors.white.withOpacity(0.2)),
            gradient: LinearGradient(
              colors: [
                Colors.white.withOpacity(0.28),
                Colors.white.withOpacity(0.08),
              ],
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
            ),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.08),
                blurRadius: 30,
                offset: const Offset(0, 20),
              ),
            ],
          ),
          child: child,
        ),
      ),
    );
  }
}


