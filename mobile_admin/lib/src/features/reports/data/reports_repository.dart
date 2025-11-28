import 'dart:convert';

import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/report_models.dart';

final reportsRepositoryProvider = Provider<ReportsRepository>((ref) {
  return ReportsRepository(client: ref.watch(apiClientProvider));
});

class ReportsRepository {
  ReportsRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<ReportPoint>> fetchSummary() async {
    final response = await _client.get<Map<String, dynamic>>('/reports/summary');
    final root = response.data ?? <String, dynamic>{};
    final data = (root['data'] as Map<String, dynamic>?)?['sales'] as List<dynamic>? ?? [];
    return data.map((point) => ReportPoint.fromJson(point as Map<String, dynamic>)).toList();
  }

  Future<ExportFile> export(String type) async {
    final response = await _client.get<Map<String, dynamic>>('/reports/export/$type');
    final data = response.data ?? <String, dynamic>{};
    final content = data['content'] as String? ?? '';
    return ExportFile(
      filename: data['filename'] as String? ?? 'report.csv',
      bytes: base64Decode(content),
    );
  }
}

