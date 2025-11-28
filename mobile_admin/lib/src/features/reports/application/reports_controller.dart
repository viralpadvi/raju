import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/reports_repository.dart';
import '../domain/report_models.dart';

final reportsControllerProvider =
    StateNotifierProvider<ReportsController, ReportsState>((ref) {
  final repository = ref.watch(reportsRepositoryProvider);
  final controller = ReportsController(repository: repository);
  controller.refresh();
  return controller;
});

class ReportsController extends StateNotifier<ReportsState> {
  ReportsController({required ReportsRepository repository})
      : _repository = repository,
        super(const ReportsState.initial());

  final ReportsRepository _repository;

  Future<void> refresh() async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final summary = await _repository.fetchSummary();
      state = state.copyWith(isLoading: false, points: summary);
    } catch (error) {
      state = state.copyWith(isLoading: false, errorMessage: error.toString());
    }
  }

  Future<ExportFile?> export(String type) async {
    try {
      final file = await _repository.export(type);
      state = state.copyWith(lastExport: file.filename);
      return file;
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
      return null;
    }
  }
}

class ReportsState {
  const ReportsState({
    required this.isLoading,
    required this.points,
    required this.errorMessage,
    required this.lastExport,
  });

  const ReportsState.initial()
      : isLoading = false,
        points = const [],
        errorMessage = null,
        lastExport = null;

  final bool isLoading;
  final List<ReportPoint> points;
  final String? errorMessage;
  final String? lastExport;

  ReportsState copyWith({
    bool? isLoading,
    List<ReportPoint>? points,
    String? errorMessage,
    String? lastExport,
  }) {
    return ReportsState(
      isLoading: isLoading ?? this.isLoading,
      points: points ?? this.points,
      errorMessage: errorMessage,
      lastExport: lastExport ?? this.lastExport,
    );
  }
}

