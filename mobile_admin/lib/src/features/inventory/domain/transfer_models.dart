// Transfer models - Ready for when API is implemented
// Note: The backend API for transfers needs to be created first

class TransferDto {
  TransferDto({
    required this.id,
    required this.transferNumber,
    required this.fromBranchId,
    required this.toBranchId,
    required this.transferDate,
    this.expectedDate,
    required this.status,
    this.notes,
    this.fromBranch,
    this.toBranch,
    this.createdAt,
    this.updatedAt,
  });

  factory TransferDto.fromJson(Map<String, dynamic> json) {
    return TransferDto(
      id: json['id'] as int? ?? 0,
      transferNumber: json['transfer_number'] as String? ?? '',
      fromBranchId: json['from_branch_id'] as int? ?? 0,
      toBranchId: json['to_branch_id'] as int? ?? 0,
      transferDate: json['transfer_date'] != null
          ? DateTime.tryParse(json['transfer_date'] as String) ?? DateTime.now()
          : DateTime.now(),
      expectedDate: json['expected_date'] != null
          ? DateTime.tryParse(json['expected_date'] as String)
          : null,
      status: json['status'] as String? ?? 'pending',
      notes: json['notes'] as String?,
      fromBranch: json['from_branch'] != null
          ? BranchInfo.fromJson(json['from_branch'] as Map<String, dynamic>)
          : null,
      toBranch: json['to_branch'] != null
          ? BranchInfo.fromJson(json['to_branch'] as Map<String, dynamic>)
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
  final String transferNumber;
  final int fromBranchId;
  final int toBranchId;
  final DateTime transferDate;
  final DateTime? expectedDate;
  final String status;
  final String? notes;
  final BranchInfo? fromBranch;
  final BranchInfo? toBranch;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get fromBranchName => fromBranch?.name ?? 'Unknown';
  String get toBranchName => toBranch?.name ?? 'Unknown';

  Map<String, dynamic> toJson() => {
        'id': id,
        'transfer_number': transferNumber,
        'from_branch_id': fromBranchId,
        'to_branch_id': toBranchId,
        'transfer_date': transferDate.toIso8601String().split('T')[0],
        if (expectedDate != null) 'expected_date': expectedDate!.toIso8601String().split('T')[0],
        'status': status,
        'notes': notes,
      };
}

class TransferPayload {
  TransferPayload({
    required this.fromBranchId,
    required this.toBranchId,
    required this.transferDate,
    this.expectedDate,
    this.status,
    this.notes,
  });

  final int fromBranchId;
  final int toBranchId;
  final DateTime transferDate;
  final DateTime? expectedDate;
  final String? status;
  final String? notes;

  Map<String, dynamic> toJson() => {
        'from_branch_id': fromBranchId,
        'to_branch_id': toBranchId,
        'transfer_date': transferDate.toIso8601String().split('T')[0],
        if (expectedDate != null) 'expected_date': expectedDate!.toIso8601String().split('T')[0],
        if (status != null) 'status': status,
        if (notes != null) 'notes': notes,
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

