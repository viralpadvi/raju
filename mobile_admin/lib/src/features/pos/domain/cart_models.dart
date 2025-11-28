class CartItem {
  CartItem({
    required this.id,
    required this.name,
    required this.price,
    required this.quantity,
  });

  final String id;
  final String name;
  final double price;
  final int quantity;

  double get lineTotal => price * quantity;

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'price': price,
        'quantity': quantity,
      };
}

class SalePayload {
  SalePayload({
    required this.items,
    required this.total,
    this.customerId,
    this.registerId,
    this.paymentMethod = 'cash',
    this.notes,
  });

  final List<CartItem> items;
  final double total;
  final int? customerId;
  final int? registerId;
  final String paymentMethod;
  final String? notes;

  Map<String, dynamic> toJson() => {
        'items': items
            .map(
              (item) => {
                'product_id': int.tryParse(item.id) ?? 0,
                'quantity': item.quantity,
                'price': item.price,
              },
            )
            .toList(),
        'total_amount': total,
        'subtotal': total,
        'tax_amount': 0,
        'discount_amount': 0,
        'payment_method': paymentMethod,
        if (customerId != null) 'customer_id': customerId,
        if (registerId != null) 'register_id': registerId,
        if (notes != null) 'notes': notes,
      };
}

