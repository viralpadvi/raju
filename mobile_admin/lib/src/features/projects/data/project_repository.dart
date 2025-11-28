import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:dio/dio.dart';
import 'dart:io';

import '../../../core/network/api_client.dart';
import '../domain/project_models.dart';

final projectRepositoryProvider = Provider<ProjectRepository>((ref) {
  return ProjectRepository(client: ref.watch(apiClientProvider));
});

class ProjectRepository {
  ProjectRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Dio get _dio => _client.dio;

  Future<List<ProjectDto>> fetchProjects({
    String? search,
    String? status,
    String? category,
    bool? isActive,
    bool? isFeatured,
  }) async {
    final queryParams = <String, dynamic>{};
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (status != null) {
      queryParams['status'] = status;
    }
    if (category != null) {
      queryParams['category'] = category;
    }
    if (isActive != null) {
      queryParams['is_active'] = isActive;
    }
    if (isFeatured != null) {
      queryParams['is_featured'] = isFeatured;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/projects',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => ProjectDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<ProjectDto> getProject(int id) async {
    final response = await _client.get<Map<String, dynamic>>('/projects/$id');
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return ProjectDto.fromJson(data);
  }

  Future<ProjectDto> createProject(
    ProjectPayload payload, {
    List<File>? images,
    List<File>? videos,
    File? clientLogo,
  }) async {
    final formData = FormData.fromMap(payload.toJson());

    // Add images
    if (images != null && images.isNotEmpty) {
      for (var i = 0; i < images.length; i++) {
        formData.files.add(MapEntry(
          'images[]',
          await MultipartFile.fromFile(images[i].path, filename: images[i].path.split('/').last),
        ));
      }
    }

    // Add videos
    if (videos != null && videos.isNotEmpty) {
      for (var i = 0; i < videos.length; i++) {
        formData.files.add(MapEntry(
          'videos[]',
          await MultipartFile.fromFile(videos[i].path, filename: videos[i].path.split('/').last),
        ));
      }
    }

    // Add client logo
    if (clientLogo != null) {
      formData.files.add(MapEntry(
        'client_logo',
        await MultipartFile.fromFile(clientLogo.path, filename: clientLogo.path.split('/').last),
      ));
    }

    final response = await _dio.post<Map<String, dynamic>>(
      '/projects',
      data: formData,
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return ProjectDto.fromJson(data);
  }

  Future<ProjectDto> updateProject(
    int id,
    ProjectPayload payload, {
    List<File>? images,
    List<File>? videos,
    File? clientLogo,
    List<String>? existingImages,
    List<String>? existingVideos,
  }) async {
    final formData = FormData.fromMap(payload.toJson());

    // Add existing images as array
    if (existingImages != null && existingImages.isNotEmpty) {
      for (final imageUrl in existingImages) {
        formData.fields.add(MapEntry('images[]', imageUrl));
      }
    }

    // Add new images
    if (images != null && images.isNotEmpty) {
      for (var i = 0; i < images.length; i++) {
        formData.files.add(MapEntry(
          'images[]',
          await MultipartFile.fromFile(images[i].path, filename: images[i].path.split('/').last),
        ));
      }
    }

    // Add existing videos as array
    if (existingVideos != null && existingVideos.isNotEmpty) {
      for (final videoUrl in existingVideos) {
        formData.fields.add(MapEntry('videos[]', videoUrl));
      }
    }

    // Add new videos
    if (videos != null && videos.isNotEmpty) {
      for (var i = 0; i < videos.length; i++) {
        formData.files.add(MapEntry(
          'videos[]',
          await MultipartFile.fromFile(videos[i].path, filename: videos[i].path.split('/').last),
        ));
      }
    }

    // Add client logo
    if (clientLogo != null) {
      formData.files.add(MapEntry(
        'client_logo',
        await MultipartFile.fromFile(clientLogo.path, filename: clientLogo.path.split('/').last),
      ));
    }

    final response = await _dio.post<Map<String, dynamic>>(
      '/projects/$id',
      data: formData,
      queryParameters: {'_method': 'PUT'},
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return ProjectDto.fromJson(data);
  }

  Future<void> deleteProject(int id) async {
    await _client.delete('/projects/$id');
  }
}

