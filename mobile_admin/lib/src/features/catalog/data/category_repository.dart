import 'package:dio/dio.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:image_picker/image_picker.dart';

import '../../../core/network/api_client.dart';
import '../domain/category_models.dart';

final categoryRepositoryProvider = Provider<CategoryRepository>((ref) {
  return CategoryRepository(client: ref.watch(apiClientProvider));
});

class CategoryRepository {
  CategoryRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<CategoryDto>> fetchCategories({
    String? search,
    bool? status,
    bool tree = false,
  }) async {
    final queryParams = <String, dynamic>{
      if (tree) 'tree': true,
    };
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (status != null) {
      queryParams['status'] = status;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/catalog/categories',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => CategoryDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<CategoryDto> createCategory(CategoryPayload payload, {XFile? imageFile}) async {
    if (imageFile != null) {
      final formData = FormData.fromMap(payload.toJson());
      final bytes = await imageFile.readAsBytes();
      formData.files.add(
        MapEntry(
          'image',
          MultipartFile.fromBytes(
            bytes,
            filename: imageFile.name,
          ),
        ),
      );
      final response = await _client.dio.post<Map<String, dynamic>>(
        '/catalog/categories',
        data: formData,
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return CategoryDto.fromJson(data);
    } else {
      final response = await _client.post<Map<String, dynamic>>(
        '/catalog/categories',
        data: payload.toJson(),
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return CategoryDto.fromJson(data);
    }
  }

  Future<CategoryDto> updateCategory(int id, CategoryPayload payload, {XFile? imageFile}) async {
    if (imageFile != null) {
      final formData = FormData.fromMap(payload.toJson());
      final bytes = await imageFile.readAsBytes();
      formData.files.add(
        MapEntry(
          'image',
          MultipartFile.fromBytes(
            bytes,
            filename: imageFile.name,
          ),
        ),
      );
      final response = await _client.dio.post<Map<String, dynamic>>(
        '/catalog/categories/$id',
        data: formData,
        queryParameters: {'_method': 'PUT'},
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return CategoryDto.fromJson(data);
    } else {
      final response = await _client.put<Map<String, dynamic>>(
        '/catalog/categories/$id',
        data: payload.toJson(),
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return CategoryDto.fromJson(data);
    }
  }

  Future<void> deleteCategory(int id) async {
    await _client.delete('/catalog/categories/$id');
  }
}

