import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'dart:io';

import '../data/project_repository.dart';
import '../domain/project_models.dart';

final projectControllerProvider =
    StateNotifierProvider<ProjectController, ProjectState>((ref) {
  final repository = ref.watch(projectRepositoryProvider);
  final controller = ProjectController(repository: repository);
  controller.bootstrap();
  return controller;
});

class ProjectController extends StateNotifier<ProjectState> {
  ProjectController({required ProjectRepository repository})
      : _repository = repository,
        super(const ProjectState.initial());

  final ProjectRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
  }

  Future<void> refresh({
    String? search,
    String? status,
    String? category,
    bool? isActive,
    bool? isFeatured,
  }) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final projects = await _repository.fetchProjects(
        search: search,
        status: status,
        category: category,
        isActive: isActive,
        isFeatured: isFeatured,
      );
      state = state.copyWith(isLoading: false, projects: projects);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<ProjectDto?> getProject(int id) async {
    try {
      final project = await _repository.getProject(id);
      return project;
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
      return null;
    }
  }

  Future<void> createProject(
    ProjectPayload payload, {
    List<File>? images,
    List<File>? videos,
    File? clientLogo,
  }) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final project = await _repository.createProject(
        payload,
        images: images,
        videos: videos,
        clientLogo: clientLogo,
      );
      final updated = [...state.projects, project];
      state = state.copyWith(isLoading: false, projects: updated);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> updateProject(
    int id,
    ProjectPayload payload, {
    List<File>? images,
    List<File>? videos,
    File? clientLogo,
    List<String>? existingImages,
    List<String>? existingVideos,
  }) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final project = await _repository.updateProject(
        id,
        payload,
        images: images,
        videos: videos,
        clientLogo: clientLogo,
        existingImages: existingImages,
        existingVideos: existingVideos,
      );
      final updated = state.projects.map((p) => p.id == id ? project : p).toList();
      state = state.copyWith(isLoading: false, projects: updated);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> deleteProject(int id) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      await _repository.deleteProject(id);
      final updated = state.projects.where((p) => p.id != id).toList();
      state = state.copyWith(isLoading: false, projects: updated);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }
}

class ProjectState {
  const ProjectState({
    required this.isLoading,
    required this.projects,
    required this.errorMessage,
  });

  const ProjectState.initial()
      : isLoading = false,
        projects = const [],
        errorMessage = null;

  final bool isLoading;
  final List<ProjectDto> projects;
  final String? errorMessage;

  ProjectState copyWith({
    bool? isLoading,
    List<ProjectDto>? projects,
    String? errorMessage,
  }) {
    return ProjectState(
      isLoading: isLoading ?? this.isLoading,
      projects: projects ?? this.projects,
      errorMessage: errorMessage,
    );
  }
}

