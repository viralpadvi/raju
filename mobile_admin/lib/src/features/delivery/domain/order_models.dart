class OrderDto {
  OrderDto({
    required this.id,
    required this.orderNumber,
    required this.customerId,
    this.customer,
    required this.deliveryAgentId,
    this.deliveryAgent,
    required this.status,
    required this.totalAmount,
    required this.subtotal,
    required this.taxAmount,
    required this.discountAmount,
    this.deliveryAddress,
    this.deliveryPhone,
    this.deliveryNotes,
    this.assignedAt,
    this.pickedUpAt,
    this.deliveredAt,
    this.createdAt,
    this.updatedAt,
    this.items = const [],
  });

  factory OrderDto.fromJson(Map<String, dynamic> json) {
    return OrderDto(
      id: json['id'] as int? ?? 0,
      orderNumber: json['order_number'] as String? ?? '',
      customerId: json['customer_id'] as int? ?? 0,
      customer: json['customer'] != null
          ? CustomerInfo.fromJson(json['customer'] as Map<String, dynamic>)
          : null,
      deliveryAgentId: json['delivery_agent_id'] as int? ?? 0,
      deliveryAgent: json['delivery_agent'] != null
          ? DeliveryAgentInfo.fromJson(json['delivery_agent'] as Map<String, dynamic>)
          : null,
      status: json['status'] as String? ?? 'pending',
      totalAmount: (json['total_amount'] as num?)?.toDouble() ?? 0,
      subtotal: (json['subtotal'] as num?)?.toDouble() ?? 0,
      taxAmount: (json['tax_amount'] as num?)?.toDouble() ?? 0,
      discountAmount: (json['discount_amount'] as num?)?.toDouble() ?? 0,
      deliveryAddress: json['delivery_address'] as String?,
      deliveryPhone: json['delivery_phone'] as String?,
      deliveryNotes: json['delivery_notes'] as String?,
      assignedAt: json['assigned_at'] != null
          ? DateTime.tryParse(json['assigned_at'] as String)
          : null,
      pickedUpAt: json['picked_up_at'] != null
          ? DateTime.tryParse(json['picked_up_at'] as String)
          : null,
      deliveredAt: json['delivered_at'] != null
          ? DateTime.tryParse(json['delivered_at'] as String)
          : null,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'] as String)
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.tryParse(json['updated_at'] as String)
          : null,
      items: (json['items'] as List<dynamic>?)
              ?.map((e) => OrderItemDto.fromJson(e as Map<String, dynamic>))
              .toList() ??
          const [],
    );
  }

  final int id;
  final String orderNumber;
  final int customerId;
  final CustomerInfo? customer;
  final int deliveryAgentId;
  final DeliveryAgentInfo? deliveryAgent;
  final String status;
  final double totalAmount;
  final double subtotal;
  final double taxAmount;
  final double discountAmount;
  final String? deliveryAddress;
  final String? deliveryPhone;
  final String? deliveryNotes;
  final DateTime? assignedAt;
  final DateTime? pickedUpAt;
  final DateTime? deliveredAt;
  final DateTime? createdAt;
  final DateTime? updatedAt;
  final List<OrderItemDto> items;

  String get customerName => customer?.name ?? 'Unknown Customer';
  String get customerPhone => customer?.phone ?? deliveryPhone ?? 'N/A';
  String get formattedAddress => deliveryAddress ?? 'No address provided';

  bool get isPending => status == 'pending';
  bool get isAssigned => status == 'assigned';
  bool get isPickedUp => status == 'picked_up';
  bool get isInTransit => status == 'in_transit';
  bool get isDelivered => status == 'delivered';
  bool get isCancelled => status == 'cancelled';

  Map<String, dynamic> toJson() => {
        'id': id,
        'order_number': orderNumber,
        'customer_id': customerId,
        'delivery_agent_id': deliveryAgentId,
        'status': status,
        'total_amount': totalAmount,
      };
}

class OrderItemDto {
  OrderItemDto({
    required this.id,
    required this.productId,
    this.productName,
    required this.quantity,
    required this.unitPrice,
    required this.totalPrice,
  });

  factory OrderItemDto.fromJson(Map<String, dynamic> json) {
    return OrderItemDto(
      id: json['id'] as int? ?? 0,
      productId: json['product_id'] as int? ?? 0,
      productName: json['product_name'] as String?,
      quantity: (json['quantity'] as num?)?.toInt() ?? 0,
      unitPrice: (json['unit_price'] as num?)?.toDouble() ?? 0,
      totalPrice: (json['total_price'] as num?)?.toDouble() ?? 0,
    );
  }

  final int id;
  final int productId;
  final String? productName;
  final int quantity;
  final double unitPrice;
  final double totalPrice;
}

class CustomerInfo {
  CustomerInfo({
    required this.id,
    required this.name,
    this.phone,
    this.email,
  });

  factory CustomerInfo.fromJson(Map<String, dynamic> json) {
    return CustomerInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      phone: json['phone'] as String?,
      email: json['email'] as String?,
    );
  }

  final int id;
  final String name;
  final String? phone;
  final String? email;
}

class DeliveryAgentInfo {
  DeliveryAgentInfo({
    required this.id,
    required this.name,
    this.phone,
    this.email,
  });

  factory DeliveryAgentInfo.fromJson(Map<String, dynamic> json) {
    return DeliveryAgentInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      phone: json['phone'] as String?,
      email: json['email'] as String?,
    );
  }

  final int id;
  final String name;
  final String? phone;
  final String? email;
}

