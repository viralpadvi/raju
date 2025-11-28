class BranchDto {
  BranchDto({
    required this.id,
    required this.name,
    required this.code,
    this.address,
    this.city,
    this.state,
    this.postalCode,
    this.country,
    this.phone,
    this.email,
    this.managerId,
    this.manager,
    required this.isActive,
    this.createdAt,
    this.updatedAt,
  });

  factory BranchDto.fromJson(Map<String, dynamic> json) {
    return BranchDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      code: json['code'] as String? ?? '',
      address: json['address'] as String?,
      city: json['city'] as String?,
      state: json['state'] as String?,
      postalCode: json['postal_code'] as String?,
      country: json['country'] as String?,
      phone: json['phone'] as String?,
      email: json['email'] as String?,
      managerId: json['manager_id'] as int?,
      manager: json['manager'] != null
          ? UserInfo.fromJson(json['manager'] as Map<String, dynamic>)
          : null,
      isActive: json['is_active'] as bool? ?? false,
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
  final String code;
  final String? address;
  final String? city;
  final String? state;
  final String? postalCode;
  final String? country;
  final String? phone;
  final String? email;
  final int? managerId;
  final UserInfo? manager;
  final bool isActive;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'code': code,
        'address': address,
        'city': city,
        'state': state,
        'postal_code': postalCode,
        'country': country,
        'phone': phone,
        'email': email,
        'manager_id': managerId,
        'is_active': isActive,
      };
}

class BranchPayload {
  BranchPayload({
    required this.name,
    required this.code,
    this.address,
    this.city,
    this.state,
    this.postalCode,
    this.country,
    this.phone,
    this.email,
    this.managerId,
    this.isActive = true,
  });

  final String name;
  final String code;
  final String? address;
  final String? city;
  final String? state;
  final String? postalCode;
  final String? country;
  final String? phone;
  final String? email;
  final int? managerId;
  final bool isActive;

  Map<String, dynamic> toJson() => {
        'name': name,
        'code': code,
        if (address != null) 'address': address,
        if (city != null) 'city': city,
        if (state != null) 'state': state,
        if (postalCode != null) 'postal_code': postalCode,
        if (country != null) 'country': country,
        if (phone != null) 'phone': phone,
        if (email != null) 'email': email,
        if (managerId != null) 'manager_id': managerId,
        'is_active': isActive,
      };
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

