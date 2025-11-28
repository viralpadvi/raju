import 'dart:convert';

import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:uuid/uuid.dart';

import '../../../core/storage/key_value_store.dart';
import '../domain/product_models.dart';

final productDraftStoreProvider = Provider<ProductDraftStore>((ref) {
  return ProductDraftStore(store: ref.watch(keyValueStoreProvider));
});

class ProductDraftStore {
  ProductDraftStore({required KeyValueStore store}) : _store = store;

  static const _draftKey = 'catalog::product_drafts';
  final KeyValueStore _store;
  final _uuid = const Uuid();

  Future<List<ProductDraft>> loadDrafts() async {
    final raw = _store.read<String>(_draftKey);
    if (raw == null) {
      return [];
    }

    final List<dynamic> list = jsonDecode(raw) as List<dynamic>;
    return list.map((item) => ProductDraft.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<void> saveDraft(ProductPayload payload) async {
    final drafts = await loadDrafts();
    drafts.add(
      ProductDraft(
        localId: _uuid.v4(),
        payload: payload,
        createdAt: DateTime.now(),
      ),
    );
    await _persist(drafts);
  }

  Future<void> removeDraft(String localId) async {
    final drafts = await loadDrafts();
    drafts.removeWhere((draft) => draft.localId == localId);
    await _persist(drafts);
  }

  Future<void> clear() => _store.delete(_draftKey);

  Future<void> _persist(List<ProductDraft> drafts) {
    return _store.write(
      _draftKey,
      jsonEncode(drafts.map((draft) => draft.toJson()).toList()),
    );
  }
}

