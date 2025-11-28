// Shift models - for managing register shifts
// Note: Shift API may need to be implemented in the backend

class ShiftDto {
  ShiftDto({
    required this.id,
    required this.registerId,
    this.register,
    required this.userId,
    this.user,
    required this.startTime,
    this.endTime,
    required this.startingCash,
    this.endingCash,
    this.expectedCash,
    this.difference,
    required this.status,
    this.notes,
    this.createdAt,
    this.updatedAt,
  });

  factory ShiftDto.fromJson(Map<String, dynamic> json) {
    return ShiftDto(
      id: json['id'] as int? ?? 0,
      registerId: json['register_id'] as int? ?? 0,
      register: json['register'] != null
          ? RegisterInfo.fromJson(json['register'] as Map<String, dynamic>)
          : null,
      userId: json['user_id'] as int? ?? 0,
      user: json['user'] != null
          ? UserInfo.fromJson(json['user'] as Map<String, dynamic>)
          : null,
      startTime: json['start_time'] != null
          ? DateTime.tryParse(json['start_time'] as String) ?? DateTime.now()
          : DateTime.now(),
      endTime: json['end_time'] != null
          ? DateTime.tryParse(json['end_time'] as String)
          : null,
      startingCash: (json['starting_cash'] as num?)?.toDouble() ?? 0,
      endingCash: json['ending_cash'] != null
          ? (json['ending_cash'] as num?)?.toDouble()
          : null,
      expectedCash: json['expected_cash'] != null
          ? (json['expected_cash'] as num?)?.toDouble()
          : null,
      difference: json['difference'] != null
          ? (json['difference'] as num?)?.toDouble()
          : null,
      status: json['status'] as String? ?? 'open',
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
  final int registerId;
  final RegisterInfo? register;
  final int userId;
  final UserInfo? user;
  final DateTime startTime;
  final DateTime? endTime;
  final double startingCash;
  final double? endingCash;
  final double? expectedCash;
  final double? difference;
  final String status;
  final String? notes;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get registerName => register?.name ?? 'Unknown';
  String get userName => user?.name ?? 'Unknown';

  Duration? get duration => endTime != null ? endTime!.difference(startTime) : null;

  Map<String, dynamic> toJson() => {
        'id': id,
        'register_id': registerId,
        'user_id': userId,
        'start_time': startTime.toIso8601String(),
        'starting_cash': startingCash,
        'status': status,
      };
}

class ShiftPayload {
  ShiftPayload({
    required this.registerId,
    required this.startingCash,
    this.notes,
  });

  final int registerId;
  final double startingCash;
  final String? notes;

  Map<String, dynamic> toJson() => {
        'register_id': registerId,
        'starting_cash': startingCash,
        if (notes != null) 'notes': notes,
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

