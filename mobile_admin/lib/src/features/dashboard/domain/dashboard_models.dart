class DashboardSummary {
  DashboardSummary({
    required this.totalProducts,
    required this.totalOrders,
    required this.todaySalesCount,
    required this.todaySalesAmount,
    required this.totalRevenue,
    required this.pendingPurchases,
  });

  factory DashboardSummary.fromJson(Map<String, dynamic> json) {
    return DashboardSummary(
      totalProducts: json['total_products'] as int? ?? 0,
      totalOrders: json['total_orders'] as int? ?? 0,
      todaySalesCount: json['today_sales_count'] as int? ?? 0,
      todaySalesAmount: (json['today_sales_amount'] as num?)?.toDouble() ?? 0,
      totalRevenue: (json['total_revenue'] as num?)?.toDouble() ?? 0,
      pendingPurchases: json['pending_purchases'] as int? ?? 0,
    );
  }

  final int totalProducts;
  final int totalOrders;
  final int todaySalesCount;
  final double todaySalesAmount;
  final double totalRevenue;
  final int pendingPurchases;

  Map<String, dynamic> toJson() => {
        'total_products': totalProducts,
        'total_orders': totalOrders,
        'today_sales_count': todaySalesCount,
        'today_sales_amount': todaySalesAmount,
        'total_revenue': totalRevenue,
        'pending_purchases': pendingPurchases,
      };
}

class SaleSnapshot {
  SaleSnapshot({
    required this.saleNumber,
    required this.customerName,
    required this.totalAmount,
    required this.status,
    required this.createdAt,
  });

  factory SaleSnapshot.fromJson(Map<String, dynamic> json) {
    return SaleSnapshot(
      saleNumber: json['sale_number'] as String? ?? 'N/A',
      customerName: (json['customer'] as Map?)?['name'] as String? ?? 'Walk-in',
      totalAmount: (json['total_amount'] as num?)?.toDouble() ?? 0,
      status: json['status'] as String? ?? 'completed',
      createdAt: DateTime.tryParse(json['created_at'] as String? ?? '') ?? DateTime.now(),
    );
  }

  final String saleNumber;
  final String customerName;
  final double totalAmount;
  final String status;
  final DateTime createdAt;

  Map<String, dynamic> toJson() => {
        'sale_number': saleNumber,
        'customer_name': customerName,
        'total_amount': totalAmount,
        'status': status,
        'created_at': createdAt.toIso8601String(),
      };
}

class ProductSnapshot {
  ProductSnapshot({
    required this.name,
    required this.sku,
    required this.stockQuantity,
    required this.minStockLevel,
  });

  factory ProductSnapshot.fromJson(Map<String, dynamic> json) {
    return ProductSnapshot(
      name: json['name'] as String? ?? 'Unnamed',
      sku: json['sku'] as String? ?? '',
      stockQuantity: json['stock_quantity'] as int? ?? 0,
      minStockLevel: json['min_stock_level'] as int? ?? 0,
    );
  }

  final String name;
  final String sku;
  final int stockQuantity;
  final int minStockLevel;

  Map<String, dynamic> toJson() => {
        'name': name,
        'sku': sku,
        'stock_quantity': stockQuantity,
        'min_stock_level': minStockLevel,
      };
}

