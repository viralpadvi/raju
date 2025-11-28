import 'dart:convert';

import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/connectivity/connectivity_provider.dart';
import '../../../core/storage/key_value_store.dart';
import '../data/catalog_repository.dart';
import '../data/product_draft_store.dart';
import '../domain/product_models.dart';

final productControllerProvider =
    StateNotifierProvider<ProductController, ProductState>((ref) {
  final repository = ref.watch(catalogRepositoryProvider);
  final draftStore = ref.watch(productDraftStoreProvider);
  final cache = ref.watch(keyValueStoreProvider);
  final controller = ProductController(
    repository: repository,
    draftStore: draftStore,
    cacheStore: cache,
  );

  controller.bootstrap(isOnline: ref.read(isOnlineProvider));

  ref.listen<bool>(isOnlineProvider, (previous, next) {
    controller.setOnlineStatus(next);
  });

  return controller;
});

class ProductController extends StateNotifier<ProductState> {
  ProductController({
    required CatalogRepository repository,
    required ProductDraftStore draftStore,
    required KeyValueStore cacheStore,
  })  : _repository = repository,
        _draftStore = draftStore,
        _cacheStore = cacheStore,
        super(const ProductState.initial());

  final CatalogRepository _repository;
  final ProductDraftStore _draftStore;
  final KeyValueStore _cacheStore;
  bool _isOnline = false;

  Future<void> bootstrap({required bool isOnline}) async {
    _isOnline = isOnline;
    await _loadCachedProducts();
    await _loadDrafts();
    if (_isOnline) {
      await refresh();
      await syncDrafts();
    }
  }

  void setOnlineStatus(bool value) {
    if (_isOnline == value) return;
    _isOnline = value;
    if (_isOnline) {
      refresh();
      syncDrafts();
    }
  }

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final products = await _repository.fetchProducts();
      await _cacheProducts(products);
      state = state.copyWith(isLoading: false, products: products);
    } catch (error) {
      state = state.copyWith(isLoading: false, errorMessage: error.toString());
    }
  }

  Future<void> createProduct(
    ProductPayload payload, {
    List<ProductImageUpload>? images,
  }) async {
    if (_isOnline) {
      final product = await _repository.createProduct(
        payload,
        images: images,
      );
      final updated = [...state.products, product];
      state = state.copyWith(products: updated);
      await _cacheProducts(updated);
      return;
    }

    await _draftStore.saveDraft(payload);
    await _loadDrafts();
  }

  Future<void> updateProduct(int id, ProductPayload payload) async {
    if (!_isOnline) {
      state = state.copyWith(
        errorMessage: 'Cannot update product while offline',
      );
      return;
    }

    try {
      final product = await _repository.updateProduct(id, payload);
      final updated =
          state.products.map((p) => p.id == id ? product : p).toList();
      state = state.copyWith(products: updated);
      await _cacheProducts(updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> deleteProduct(int id) async {
    if (!_isOnline) {
      state = state.copyWith(
        errorMessage: 'Cannot delete product while offline',
      );
      return;
    }

    try {
      await _repository.deleteProduct(id);
      final updated = state.products.where((p) => p.id != id).toList();
      state = state.copyWith(products: updated);
      await _cacheProducts(updated);
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
    }
  }

  Future<void> syncDrafts() async {
    final drafts = await _draftStore.loadDrafts();
    if (drafts.isEmpty || !_isOnline) return;

    for (final draft in drafts) {
      try {
        final product = await _repository.createProduct(draft.payload);
        final updated = [...state.products, product];
        state = state.copyWith(products: updated);
        await _draftStore.removeDraft(draft.localId);
      } catch (_) {
        break;
      }
    }

    await _cacheProducts(state.products);
    await _loadDrafts();
  }

  Future<void> _loadCachedProducts() async {
    final raw = _cacheStore.read<String>(_cacheKeys.products);
    if (raw == null) return;

    final List<dynamic> list = jsonDecode(raw) as List<dynamic>;
    final products = list.map((item) => ProductDto.fromJson(item as Map<String, dynamic>)).toList();
    state = state.copyWith(products: products);
  }

  Future<void> _cacheProducts(List<ProductDto> products) {
    return _cacheStore.write(
      _cacheKeys.products,
      jsonEncode(products.map((p) => p.toJson()).toList()),
    );
  }

  Future<void> _loadDrafts() async {
    final drafts = await _draftStore.loadDrafts();
    state = state.copyWith(drafts: drafts);
  }
}

class ProductState {
  const ProductState({
    required this.isLoading,
    required this.products,
    required this.drafts,
    required this.errorMessage,
  });

  const ProductState.initial()
      : isLoading = false,
        products = const [],
        drafts = const [],
        errorMessage = null;

  final bool isLoading;
  final List<ProductDto> products;
  final List<ProductDraft> drafts;
  final String? errorMessage;

  ProductState copyWith({
    bool? isLoading,
    List<ProductDto>? products,
    List<ProductDraft>? drafts,
    String? errorMessage,
  }) {
    return ProductState(
      isLoading: isLoading ?? this.isLoading,
      products: products ?? this.products,
      drafts: drafts ?? this.drafts,
      errorMessage: errorMessage,
    );
  }
}

abstract class _cacheKeys {
  static const products = 'catalog::products';
}

