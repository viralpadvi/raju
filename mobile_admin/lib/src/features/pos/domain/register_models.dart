class RegisterDto {
  RegisterDto({
    required this.id,
    required this.name,
    required this.code,
    required this.branchId,
    this.branch,
    this.description,
    this.initialCash,
    required this.isActive,
    this.createdAt,
    this.updatedAt,
  });

  factory RegisterDto.fromJson(Map<String, dynamic> json) {
    return RegisterDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      code: json['code'] as String? ?? '',
      branchId: json['branch_id'] as int? ?? 0,
      branch: json['branch'] != null
          ? BranchInfo.fromJson(json['branch'] as Map<String, dynamic>)
          : null,
      description: json['description'] as String?,
      initialCash: json['initial_cash'] != null
          ? (json['initial_cash'] as num?)?.toDouble()
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
  final int branchId;
  final BranchInfo? branch;
  final String? description;
  final double? initialCash;
  final bool isActive;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get branchName => branch?.name ?? 'Unknown';

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'code': code,
        'branch_id': branchId,
        'description': description,
        'initial_cash': initialCash,
        'is_active': isActive,
      };
}

class RegisterPayload {
  RegisterPayload({
    required this.name,
    required this.code,
    required this.branchId,
    this.description,
    this.initialCash,
    this.isActive = true,
  });

  final String name;
  final String code;
  final int branchId;
  final String? description;
  final double? initialCash;
  final bool isActive;

  Map<String, dynamic> toJson() => {
        'name': name,
        'code': code,
        'branch_id': branchId,
        if (description != null) 'description': description,
        if (initialCash != null) 'initial_cash': initialCash,
        'is_active': isActive,
      };
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

