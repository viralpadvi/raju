class RoleDto {
  RoleDto({
    required this.id,
    required this.name,
    this.slug,
    this.description,
    required this.isActive,
    this.usersCount,
    this.permissions = const [],
    this.createdAt,
    this.updatedAt,
  });

  factory RoleDto.fromJson(Map<String, dynamic> json) {
    return RoleDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String?,
      description: json['description'] as String?,
      isActive: json['is_active'] as bool? ?? true,
      usersCount: json['users_count'] as int?,
      permissions: (json['permissions'] as List<dynamic>?)
              ?.map((e) => PermissionInfo.fromJson(e as Map<String, dynamic>))
              .toList() ??
          const [],
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
  final bool isActive;
  final int? usersCount;
  final List<PermissionInfo> permissions;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'slug': slug,
        'description': description,
        'is_active': isActive,
      };
}

class RolePayload {
  RolePayload({
    required this.name,
    this.slug,
    this.description,
    this.isActive = true,
    this.permissionIds = const [],
  });

  final String name;
  final String? slug;
  final String? description;
  final bool isActive;
  final List<int> permissionIds;

  Map<String, dynamic> toJson() => {
        'name': name,
        if (slug != null) 'slug': slug,
        if (description != null) 'description': description,
        'is_active': isActive,
        if (permissionIds.isNotEmpty) 'permissions': permissionIds,
      };
}

class PermissionDto {
  PermissionDto({
    required this.id,
    required this.name,
    required this.slug,
    this.module,
    this.description,
  });

  factory PermissionDto.fromJson(Map<String, dynamic> json) {
    return PermissionDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String? ?? '',
      module: json['module'] as String?,
      description: json['description'] as String?,
    );
  }

  final int id;
  final String name;
  final String slug;
  final String? module;
  final String? description;

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'slug': slug,
        'module': module,
        'description': description,
      };
}

class PermissionInfo {
  PermissionInfo({required this.id, required this.name, this.slug, this.module});

  factory PermissionInfo.fromJson(Map<String, dynamic> json) {
    return PermissionInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String?,
      module: json['module'] as String?,
    );
  }

  final int id;
  final String name;
  final String? slug;
  final String? module;
}

