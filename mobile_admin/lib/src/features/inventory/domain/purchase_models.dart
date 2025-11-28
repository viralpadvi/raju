class PurchaseDto {
  PurchaseDto({
    required this.id,
    required this.purchaseNumber,
    required this.supplierId,
    required this.branchId,
    required this.purchaseDate,
    this.expectedDate,
    required this.subtotal,
    required this.taxAmount,
    required this.discountAmount,
    required this.totalAmount,
    required this.status,
    this.notes,
    this.supplier,
    this.branch,
    this.createdAt,
    this.updatedAt,
  });

  factory PurchaseDto.fromJson(Map<String, dynamic> json) {
    return PurchaseDto(
      id: json['id'] as int? ?? 0,
      purchaseNumber: json['purchase_number'] as String? ?? '',
      supplierId: json['supplier_id'] as int? ?? 0,
      branchId: json['branch_id'] as int? ?? 0,
      purchaseDate: json['purchase_date'] != null
          ? DateTime.tryParse(json['purchase_date'] as String) ?? DateTime.now()
          : DateTime.now(),
      expectedDate: json['expected_date'] != null
          ? DateTime.tryParse(json['expected_date'] as String)
          : null,
      subtotal: (json['subtotal'] as num?)?.toDouble() ?? 0,
      taxAmount: (json['tax_amount'] as num?)?.toDouble() ?? 0,
      discountAmount: (json['discount_amount'] as num?)?.toDouble() ?? 0,
      totalAmount: (json['total_amount'] as num?)?.toDouble() ?? 0,
      status: json['status'] as String? ?? 'pending',
      notes: json['notes'] as String?,
      supplier: json['supplier'] != null
          ? SupplierInfo.fromJson(json['supplier'] as Map<String, dynamic>)
          : null,
      branch: json['branch'] != null
          ? BranchInfo.fromJson(json['branch'] as Map<String, dynamic>)
          : null,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'] as String)
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.tryParse(json['updated_at'] as String)
          : null,
    );
  }

  final int id;
  final String purchaseNumber;
  final int supplierId;
  final int branchId;
  final DateTime purchaseDate;
  final DateTime? expectedDate;
  final double subtotal;
  final double taxAmount;
  final double discountAmount;
  final double totalAmount;
  final String status;
  final String? notes;
  final SupplierInfo? supplier;
  final BranchInfo? branch;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get supplierName => supplier?.name ?? 'Unknown';
  String get branchName => branch?.name ?? 'Main';

  Map<String, dynamic> toJson() => {
        'id': id,
        'purchase_number': purchaseNumber,
        'supplier_id': supplierId,
        'branch_id': branchId,
        'purchase_date': purchaseDate.toIso8601String().split('T')[0],
        'expected_date': expectedDate?.toIso8601String().split('T')[0],
        'subtotal': subtotal,
        'tax_amount': taxAmount,
        'discount_amount': discountAmount,
        'total_amount': totalAmount,
        'status': status,
        'notes': notes,
      };
}

class PurchasePayload {
  PurchasePayload({
    required this.supplierId,
    required this.branchId,
    required this.purchaseDate,
    this.expectedDate,
    required this.subtotal,
    this.taxAmount,
    this.discountAmount,
    required this.totalAmount,
    this.status,
    this.notes,
  });

  final int supplierId;
  final int branchId;
  final DateTime purchaseDate;
  final DateTime? expectedDate;
  final double subtotal;
  final double? taxAmount;
  final double? discountAmount;
  final double totalAmount;
  final String? status;
  final String? notes;

  Map<String, dynamic> toJson() => {
        'supplier_id': supplierId,
        'branch_id': branchId,
        'purchase_date': purchaseDate.toIso8601String().split('T')[0],
        if (expectedDate != null) 'expected_date': expectedDate!.toIso8601String().split('T')[0],
        'subtotal': subtotal,
        if (taxAmount != null) 'tax_amount': taxAmount,
        if (discountAmount != null) 'discount_amount': discountAmount,
        'total_amount': totalAmount,
        if (status != null) 'status': status,
        if (notes != null) 'notes': notes,
      };
}

class SupplierInfo {
  SupplierInfo({required this.id, required this.name});

  factory SupplierInfo.fromJson(Map<String, dynamic> json) {
    return SupplierInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
    );
  }

  final int id;
  final String name;
}

class BranchInfo {
  BranchInfo({required this.id, required this.name});

  factory BranchInfo.fromJson(Map<String, dynamic> json) {
    return BranchInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
    );
  }

  final int id;
  final String name;
}

