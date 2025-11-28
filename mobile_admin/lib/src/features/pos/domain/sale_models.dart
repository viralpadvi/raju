class SaleDto {
  SaleDto({
    required this.id,
    required this.saleNumber,
    required this.registerId,
    this.register,
    required this.userId,
    this.user,
    this.customerId,
    this.customer,
    required this.subtotal,
    required this.taxAmount,
    required this.discountAmount,
    required this.totalAmount,
    required this.paymentMethod,
    required this.status,
    this.notes,
    this.createdAt,
    this.updatedAt,
  });

  factory SaleDto.fromJson(Map<String, dynamic> json) {
    return SaleDto(
      id: json['id'] as int? ?? 0,
      saleNumber: json['sale_number'] as String? ?? '',
      registerId: json['register_id'] as int? ?? 0,
      register: json['register'] != null
          ? RegisterInfo.fromJson(json['register'] as Map<String, dynamic>)
          : null,
      userId: json['user_id'] as int? ?? 0,
      user: json['user'] != null
          ? UserInfo.fromJson(json['user'] as Map<String, dynamic>)
          : null,
      customerId: json['customer_id'] as int?,
      customer: json['customer'] != null
          ? UserInfo.fromJson(json['customer'] as Map<String, dynamic>)
          : null,
      subtotal: (json['subtotal'] as num?)?.toDouble() ?? 0,
      taxAmount: (json['tax_amount'] as num?)?.toDouble() ?? 0,
      discountAmount: (json['discount_amount'] as num?)?.toDouble() ?? 0,
      totalAmount: (json['total_amount'] as num?)?.toDouble() ?? 0,
      paymentMethod: json['payment_method'] as String? ?? 'cash',
      status: json['status'] as String? ?? 'completed',
      notes: json['notes'] as String?,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'] as String)
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.tryParse(json['updated_at'] as String)
          : null,
    );
  }

  final int id;
  final String saleNumber;
  final int registerId;
  final RegisterInfo? register;
  final int userId;
  final UserInfo? user;
  final int? customerId;
  final UserInfo? customer;
  final double subtotal;
  final double taxAmount;
  final double discountAmount;
  final double totalAmount;
  final String paymentMethod;
  final String status;
  final String? notes;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get registerName => register?.name ?? 'Unknown';
  String get userName => user?.name ?? 'Unknown';
  String get customerName => customer?.name ?? 'Walk-in';

  Map<String, dynamic> toJson() => {
        'id': id,
        'sale_number': saleNumber,
        'register_id': registerId,
        'total_amount': totalAmount,
        'payment_method': paymentMethod,
        'status': status,
      };
}

class RegisterInfo {
  RegisterInfo({required this.id, required this.name});

  factory RegisterInfo.fromJson(Map<String, dynamic> json) {
    return RegisterInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
    );
  }

  final int id;
  final String name;
}

class UserInfo {
  UserInfo({required this.id, required this.name});

  factory UserInfo.fromJson(Map<String, dynamic> json) {
    return UserInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
    );
  }

  final int id;
  final String name;
}

