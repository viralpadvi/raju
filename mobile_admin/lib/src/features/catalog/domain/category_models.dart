class CategoryDto {
  CategoryDto({
    required this.id,
    required this.name,
    this.slug,
    this.description,
    this.icon,
    this.image,
    this.parentId,
    required this.isActive,
    this.sortOrder,
    this.children,
    this.parent,
    this.createdAt,
    this.updatedAt,
  });

  factory CategoryDto.fromJson(Map<String, dynamic> json) {
    return CategoryDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String?,
      description: json['description'] as String?,
      icon: json['icon'] as String?,
      image: json['image'] as String?,
      parentId: json['parent_id'] as int?,
      isActive: json['is_active'] as bool? ?? false,
      sortOrder: json['sort_order'] as int?,
      children: json['children'] != null
          ? (json['children'] as List<dynamic>)
              .map((item) => CategoryDto.fromJson(item as Map<String, dynamic>))
              .toList()
          : null,
      parent: json['parent'] != null
          ? CategoryDto.fromJson(json['parent'] as Map<String, dynamic>)
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
  final String name;
  final String? slug;
  final String? description;
  final String? icon;
  final String? image;
  final int? parentId;
  final bool isActive;
  final int? sortOrder;
  final List<CategoryDto>? children;
  final CategoryDto? parent;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'slug': slug,
        'description': description,
        'icon': icon,
        'image': image,
        'parent_id': parentId,
        'is_active': isActive,
        'sort_order': sortOrder,
      };
}

class CategoryPayload {
  CategoryPayload({
    required this.name,
    this.slug,
    this.description,
    this.icon,
    this.image,
    this.parentId,
    this.isActive = true,
    this.sortOrder,
  });

  final String name;
  final String? slug;
  final String? description;
  final String? icon;
  final String? image;
  final int? parentId;
  final bool isActive;
  final int? sortOrder;

  Map<String, dynamic> toJson() => {
        'name': name,
        if (slug != null) 'slug': slug,
        if (description != null) 'description': description,
        if (icon != null) 'icon': icon,
        if (image != null) 'image': image,
        if (parentId != null) 'parent_id': parentId,
        'is_active': isActive,
        if (sortOrder != null) 'sort_order': sortOrder,
      };
}

