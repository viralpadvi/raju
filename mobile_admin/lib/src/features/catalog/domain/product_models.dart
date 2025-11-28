import 'dart:convert';
import 'dart:typed_data';

class ProductDto {
  ProductDto({
    required this.id,
    required this.name,
    required this.sku,
    required this.price,
    required this.stockQuantity,
    required this.isActive,
    this.description,
    this.slug,
    this.compareAtPrice,
    this.costPrice,
    this.salePrice,
    this.gstRate,
    this.hsnCode,
    this.barcode,
    this.minStockLevel,
    this.weight,
    this.dimensions,
    this.color,
    this.size,
    this.specifications,
    this.images,
    this.isFeatured = false,
    this.discountValue,
    this.discountType,
    this.discountStartAt,
    this.discountEndAt,
    this.seoTitle,
    this.seoDescription,
    this.seoKeywords,
    this.sortOrder,
    this.brand,
    this.category,
    this.brandId,
    required this.categoryId,
  });

  factory ProductDto.fromJson(Map<String, dynamic> json) {
    DateTime? parseDate(dynamic value) {
      if (value == null) return null;
      return DateTime.tryParse(value.toString());
    }

    List<String>? parseImages(dynamic value) {
      if (value == null) return null;
      if (value is List) {
        return value.map((e) => e.toString()).toList();
      }
      return null;
    }

    Map<String, dynamic>? parseSpecifications(dynamic value) {
      if (value == null) return null;
      if (value is Map) {
        return Map<String, dynamic>.from(value);
      }
      if (value is String) {
        try {
          return Map<String, dynamic>.from(jsonDecode(value));
        } catch (_) {
          return null;
        }
      }
      return null;
    }

    return ProductDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      sku: json['sku'] as String? ?? '',
      price: (json['price'] as num?)?.toDouble() ?? 0,
      stockQuantity: json['stock_quantity'] as int? ?? 0,
      isActive: json['is_active'] as bool? ?? false,
      description: json['description'] as String?,
      slug: json['slug'] as String?,
      compareAtPrice: (json['compare_price'] as num?)?.toDouble(),
      costPrice: (json['cost_price'] as num?)?.toDouble(),
      salePrice: (json['sale_price'] as num?)?.toDouble(),
      gstRate: (json['gst_rate'] as num?)?.toDouble(),
      hsnCode: json['hsn_code'] as String?,
      barcode: json['barcode'] as String?,
      minStockLevel: json['min_stock_level'] as int?,
      weight: (json['weight'] as num?)?.toDouble(),
      dimensions: json['dimensions'] as String?,
      color: json['color'] as String?,
      size: json['size'] as String?,
      specifications: parseSpecifications(json['specifications']),
      images: parseImages(json['images']),
      isFeatured: json['is_featured'] as bool? ?? false,
      discountValue: (json['discount_value'] as num?)?.toDouble(),
      discountType: json['discount_type'] as String?,
      discountStartAt: parseDate(json['discount_start_at']),
      discountEndAt: parseDate(json['discount_end_at']),
      seoTitle: json['seo_title'] as String?,
      seoDescription: json['seo_description'] as String?,
      seoKeywords: json['seo_keywords'] as String?,
      sortOrder: json['sort_order'] as int?,
      brand: json['brand'] != null
          ? BrandInfo.fromJson(json['brand'] as Map<String, dynamic>)
          : null,
      category: json['category'] != null
          ? CategoryInfo.fromJson(json['category'] as Map<String, dynamic>)
          : null,
      brandId: json['brand_id'] as int?,
      categoryId: json['category_id'] as int? ?? 0,
    );
  }

  final int id;
  final String name;
  final String sku;
  final double price;
  final int stockQuantity;
  final bool isActive;
  final String? description;
  final String? slug;
  final double? compareAtPrice;
  final double? costPrice;
  final double? salePrice;
  final double? gstRate;
  final String? hsnCode;
  final String? barcode;
  final int? minStockLevel;
  final double? weight;
  final String? dimensions;
  final String? color;
  final String? size;
  final Map<String, dynamic>? specifications;
  final List<String>? images;
  final bool isFeatured;
  final double? discountValue;
  final String? discountType;
  final DateTime? discountStartAt;
  final DateTime? discountEndAt;
  final String? seoTitle;
  final String? seoDescription;
  final String? seoKeywords;
  final int? sortOrder;
  final BrandInfo? brand;
  final CategoryInfo? category;
  final int? brandId;
  final int categoryId;

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'sku': sku,
        'price': price,
        'stock_quantity': stockQuantity,
        'is_active': isActive,
        'description': description,
        if (slug != null) 'slug': slug,
        'compare_price': compareAtPrice,
        'cost_price': costPrice,
        if (salePrice != null) 'sale_price': salePrice,
        'gst_rate': gstRate,
        'hsn_code': hsnCode,
        'barcode': barcode,
        if (minStockLevel != null) 'min_stock_level': minStockLevel,
        'weight': weight,
        if (dimensions != null) 'dimensions': dimensions,
        'color': color,
        if (size != null) 'size': size,
        if (specifications != null) 'specifications': specifications,
        if (images != null) 'images': images,
        'is_featured': isFeatured,
        'discount_value': discountValue,
        'discount_type': discountType,
        'discount_start_at': discountStartAt?.toIso8601String(),
        'discount_end_at': discountEndAt?.toIso8601String(),
        'seo_title': seoTitle,
        'seo_description': seoDescription,
        'seo_keywords': seoKeywords,
        if (sortOrder != null) 'sort_order': sortOrder,
        'brand_id': brandId,
        'category_id': categoryId,
      };
}

class BrandInfo {
  BrandInfo({required this.id, required this.name});

  factory BrandInfo.fromJson(Map<String, dynamic> json) {
    return BrandInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
    );
  }

  final int id;
  final String name;
}

class CategoryInfo {
  CategoryInfo({required this.id, required this.name});

  factory CategoryInfo.fromJson(Map<String, dynamic> json) {
    return CategoryInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
    );
  }

  final int id;
  final String name;
}

class ProductPayload {
  ProductPayload({
    required this.name,
    required this.sku,
    required this.price,
    required this.stockQuantity,
    required this.categoryId,
    this.description,
    this.slug,
    this.brandId,
    this.barcode,
    this.minStockLevel,
    this.weight,
    this.dimensions,
    this.color,
    this.size,
    this.specifications,
    this.compareAtPrice,
    this.costPrice,
    this.salePrice,
    this.gstRate,
    this.hsnCode,
    this.discountValue,
    this.discountType,
    this.discountStartAt,
    this.discountEndAt,
    this.seoTitle,
    this.seoDescription,
    this.seoKeywords,
    this.isActive = true,
    this.isFeatured = false,
    this.sortOrder,
  });

  factory ProductPayload.fromJson(Map<String, dynamic> json) {
    DateTime? parseDate(dynamic value) {
      if (value == null) return null;
      return DateTime.tryParse(value.toString());
    }

    Map<String, dynamic>? parseSpecifications(dynamic value) {
      if (value == null) return null;
      if (value is Map) {
        return Map<String, dynamic>.from(value);
      }
      if (value is String) {
        try {
          return Map<String, dynamic>.from(jsonDecode(value));
        } catch (_) {
          return null;
        }
      }
      return null;
    }

    return ProductPayload(
      name: json['name'] as String? ?? '',
      sku: json['sku'] as String? ?? '',
      price: (json['price'] as num?)?.toDouble() ?? 0,
      stockQuantity: json['stock_quantity'] as int? ?? 0,
      categoryId: json['category_id'] as int? ?? 0,
      description: json['description'] as String?,
      slug: json['slug'] as String?,
      brandId: json['brand_id'] as int?,
      barcode: json['barcode'] as String?,
      minStockLevel: json['min_stock_level'] as int?,
      weight: (json['weight'] as num?)?.toDouble(),
      dimensions: json['dimensions'] as String?,
      color: json['color'] as String?,
      size: json['size'] as String?,
      specifications: parseSpecifications(json['specifications']),
      compareAtPrice: (json['compare_price'] as num?)?.toDouble(),
      costPrice: (json['cost_price'] as num?)?.toDouble(),
      salePrice: (json['sale_price'] as num?)?.toDouble(),
      gstRate: (json['gst_rate'] as num?)?.toDouble(),
      hsnCode: json['hsn_code'] as String?,
      discountValue: (json['discount_value'] as num?)?.toDouble(),
      discountType: json['discount_type'] as String?,
      discountStartAt: parseDate(json['discount_start_at']),
      discountEndAt: parseDate(json['discount_end_at']),
      seoTitle: json['seo_title'] as String?,
      seoDescription: json['seo_description'] as String?,
      seoKeywords: json['seo_keywords'] as String?,
      isActive: json['is_active'] as bool? ?? true,
      isFeatured: json['is_featured'] as bool? ?? false,
      sortOrder: json['sort_order'] as int?,
    );
  }

  final String name;
  final String sku;
  final double price;
  final int stockQuantity;
  final int categoryId;
  final String? description;
  final String? slug;
  final int? brandId;
  final String? barcode;
  final int? minStockLevel;
  final double? weight;
  final String? dimensions;
  final String? color;
  final String? size;
  final Map<String, dynamic>? specifications;
  final double? compareAtPrice;
  final double? costPrice;
  final double? salePrice;
  final double? gstRate;
  final String? hsnCode;
  final double? discountValue;
  final String? discountType;
  final DateTime? discountStartAt;
  final DateTime? discountEndAt;
  final String? seoTitle;
  final String? seoDescription;
  final String? seoKeywords;
  final bool isActive;
  final bool isFeatured;
  final int? sortOrder;

  Map<String, dynamic> toJson() => {
        'name': name,
        'sku': sku,
        'price': price,
        'stock_quantity': stockQuantity,
        'category_id': categoryId,
        if (description != null) 'description': description,
        if (slug != null) 'slug': slug,
        if (brandId != null) 'brand_id': brandId,
        if (barcode != null) 'barcode': barcode,
        if (minStockLevel != null) 'min_stock_level': minStockLevel,
        if (weight != null) 'weight': weight,
        if (dimensions != null) 'dimensions': dimensions,
        if (color != null) 'color': color,
        if (size != null) 'size': size,
        if (specifications != null) 'specifications': specifications,
        if (compareAtPrice != null) 'compare_price': compareAtPrice,
        if (costPrice != null) 'cost_price': costPrice,
        if (salePrice != null) 'sale_price': salePrice,
        if (gstRate != null) 'gst_rate': gstRate,
        if (hsnCode != null) 'hsn_code': hsnCode,
        if (discountValue != null) 'discount_value': discountValue,
        if (discountType != null) 'discount_type': discountType,
        if (discountStartAt != null)
          'discount_start_at': discountStartAt!.toIso8601String(),
        if (discountEndAt != null)
          'discount_end_at': discountEndAt!.toIso8601String(),
        if (seoTitle != null) 'seo_title': seoTitle,
        if (seoDescription != null) 'seo_description': seoDescription,
        if (seoKeywords != null) 'seo_keywords': seoKeywords,
        'is_active': isActive,
        'is_featured': isFeatured,
        if (sortOrder != null) 'sort_order': sortOrder,
      };
}

class ProductDraft {
  ProductDraft({
    required this.localId,
    required this.payload,
    required this.createdAt,
  });

  final String localId;
  final ProductPayload payload;
  final DateTime createdAt;

  Map<String, dynamic> toJson() => {
        'local_id': localId,
        'payload': payload.toJson(),
        'created_at': createdAt.toIso8601String(),
      };

  factory ProductDraft.fromJson(Map<String, dynamic> json) {
    return ProductDraft(
      localId: json['local_id'] as String,
      payload: ProductPayload.fromJson(json['payload'] as Map<String, dynamic>),
      createdAt: DateTime.parse(json['created_at'] as String),
    );
  }
}

class ProductImageUpload {
  const ProductImageUpload({
    required this.name,
    required this.bytes,
  });

  final String name;
  final Uint8List bytes;
}

