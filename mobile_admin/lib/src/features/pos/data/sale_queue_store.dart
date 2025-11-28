import 'dart:convert';

import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:uuid/uuid.dart';

import '../../../core/storage/key_value_store.dart';
import '../domain/cart_models.dart';

final saleQueueStoreProvider = Provider<SaleQueueStore>((ref) {
  return SaleQueueStore(store: ref.watch(keyValueStoreProvider));
});

class SaleQueueStore {
  SaleQueueStore({required KeyValueStore store})
      : _store = store,
        _uuid = const Uuid();

  final KeyValueStore _store;
  final Uuid _uuid;
  static const _key = 'pos::sale_queue';

  Future<List<QueuedSale>> loadQueue() async {
    final raw = _store.read<String>(_key);
    if (raw == null) return [];
    final list = jsonDecode(raw) as List<dynamic>;
    return list.map((item) => QueuedSale.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<void> enqueue(SalePayload payload) async {
    final queue = await loadQueue();
    queue.add(
      QueuedSale(
        id: _uuid.v4(),
        payload: payload,
        createdAt: DateTime.now(),
      ),
    );
    await _persist(queue);
  }

  Future<void> remove(String id) async {
    final queue = await loadQueue();
    queue.removeWhere((sale) => sale.id == id);
    await _persist(queue);
  }

  Future<void> _persist(List<QueuedSale> queue) {
    return _store.write(
      _key,
      jsonEncode(queue.map((sale) => sale.toJson()).toList()),
    );
  }
}

class QueuedSale {
  QueuedSale({
    required this.id,
    required this.payload,
    required this.createdAt,
  });

  factory QueuedSale.fromJson(Map<String, dynamic> json) {
    final items = (json['payload']['items'] as List<dynamic>)
        .map((item) => CartItem(
              id: item['product_id'].toString(),
              name: item['product_id'].toString(),
              price: (item['price'] as num).toDouble(),
              quantity: item['quantity'] as int,
            ))
        .toList();

    return QueuedSale(
      id: json['id'] as String,
      payload: SalePayload(
        items: items,
        total: (json['payload']['total_amount'] as num).toDouble(),
      ),
      createdAt: DateTime.parse(json['created_at'] as String),
    );
  }

  final String id;
  final SalePayload payload;
  final DateTime createdAt;

  Map<String, dynamic> toJson() => {
        'id': id,
        'payload': payload.toJson(),
        'created_at': createdAt.toIso8601String(),
      };
}

