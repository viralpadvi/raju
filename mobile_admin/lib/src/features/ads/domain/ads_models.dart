class AdCampaignDto {
  AdCampaignDto({
    required this.id,
    required this.name,
    required this.status,
    required this.budget,
  });

  factory AdCampaignDto.fromJson(Map<String, dynamic> json) {
    return AdCampaignDto(
      id: json['id'] as int,
      name: json['name'] as String? ?? '',
      status: json['status'] as String? ?? 'draft',
      budget: (json['budget'] as num?)?.toDouble() ?? 0,
    );
  }

  final int id;
  final String name;
  final String status;
  final double budget;
}

class AdPlacementDto {
  AdPlacementDto({
    required this.id,
    required this.name,
    required this.status,
  });

  factory AdPlacementDto.fromJson(Map<String, dynamic> json) {
    return AdPlacementDto(
      id: json['id'] as int,
      name: json['name'] as String? ?? '',
      status: json['status'] as String? ?? 'draft',
    );
  }

  final int id;
  final String name;
  final String status;
}

