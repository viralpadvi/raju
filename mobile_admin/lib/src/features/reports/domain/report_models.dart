class ReportPoint {
  const ReportPoint({required this.label, required this.total, required this.orders});

  factory ReportPoint.fromJson(Map<String, dynamic> json) {
    return ReportPoint(
      label: json['day']?.toString() ?? json['label']?.toString() ?? '',
      total: (json['total'] as num?)?.toDouble() ?? 0,
      orders: json['orders'] as int? ?? 0,
    );
  }

  final String label;
  final double total;
  final int orders;
}

class ExportFile {
  ExportFile({required this.filename, required this.bytes});

  final String filename;
  final List<int> bytes;
}

