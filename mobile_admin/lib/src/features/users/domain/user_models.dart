class UserDto {
  UserDto({
    required this.id,
    required this.name,
    required this.email,
    this.phone,
    this.role,
    this.roleId,
    this.roles = const [],
    required this.isActive,
    this.lastLoginAt,
    this.createdAt,
    this.updatedAt,
  });

  factory UserDto.fromJson(Map<String, dynamic> json) {
    return UserDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      email: json['email'] as String? ?? '',
      phone: json['phone'] as String?,
      role: json['role'] as String?,
      roleId: json['role_id'] as int?,
      roles: (json['roles'] as List<dynamic>?)
              ?.map((e) => RoleInfo.fromJson(e as Map<String, dynamic>))
              .toList() ??
          const [],
      isActive: json['is_active'] as bool? ?? true,
      lastLoginAt: json['last_login_at'] != null
          ? DateTime.tryParse(json['last_login_at'] as String)
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
  final String email;
  final String? phone;
  final String? role;
  final int? roleId;
  final List<RoleInfo> roles;
  final bool isActive;
  final DateTime? lastLoginAt;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get primaryRoleName => roles.isNotEmpty ? roles.first.name : (role ?? 'No Role');

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'email': email,
        'phone': phone,
        'role': role,
        'role_id': roleId,
        'is_active': isActive,
      };
}

class UserPayload {
  UserPayload({
    required this.name,
    required this.email,
    this.phone,
    this.password,
    this.roleId,
    this.roleIds = const [],
    this.isActive = true,
  });

  final String name;
  final String email;
  final String? phone;
  final String? password;
  final int? roleId;
  final List<int> roleIds;
  final bool isActive;

  Map<String, dynamic> toJson() => {
        'name': name,
        'email': email,
        if (phone != null) 'phone': phone,
        if (password != null) 'password': password,
        if (roleId != null) 'role_id': roleId,
        if (roleIds.isNotEmpty) 'roles': roleIds,
        'is_active': isActive,
      };
}

class RoleInfo {
  RoleInfo({required this.id, required this.name, this.slug});

  factory RoleInfo.fromJson(Map<String, dynamic> json) {
    return RoleInfo(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String?,
    );
  }

  final int id;
  final String name;
  final String? slug;
}

