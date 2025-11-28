class BrandDto {
  BrandDto({
    required this.id,
    required this.name,
    this.slug,
    this.description,
    this.logo,
    this.website,
    required this.isActive,
    this.sortOrder,
    this.productsCount,
    this.createdAt,
    this.updatedAt,
  });

  factory BrandDto.fromJson(Map<String, dynamic> json) {
    return BrandDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String?,
      description: json['description'] as String?,
      logo: json['logo'] as String?,
      website: json['website'] as String?,
      isActive: json['is_active'] as bool? ?? false,
      sortOrder: json['sort_order'] as int?,
      productsCount: json['products_count'] as int?,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'] as String)
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.tryParse(json['updated_at'] as String)
          : null,
    );
  }

  final int id;
  final String name;
  final String? slug;
  final String? description;
  final String? logo;
  final String? website;
  final bool isActive;
  final int? sortOrder;
  final int? productsCount;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'slug': slug,
        'description': description,
        'logo': logo,
        'website': website,
        'is_active': isActive,
        'sort_order': sortOrder,
        'products_count': productsCount,
      };
}

class BrandPayload {
  BrandPayload({
    required this.name,
    this.slug,
    this.description,
    this.logo,
    this.website,
    this.isActive = true,
    this.sortOrder,
  });

  final String name;
  final String? slug;
  final String? description;
  final String? logo;
  final String? website;
  final bool isActive;
  final int? sortOrder;

  Map<String, dynamic> toJson() => {
        'name': name,
        if (slug != null) 'slug': slug,
        if (description != null) 'description': description,
        if (logo != null) 'logo': logo,
        if (website != null) 'website': website,
        'is_active': isActive,
        if (sortOrder != null) 'sort_order': sortOrder,
      };
}

