import 'package:dio/dio.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/product_models.dart';

final catalogRepositoryProvider = Provider<CatalogRepository>((ref) {
  return CatalogRepository(client: ref.watch(apiClientProvider));
});

class CatalogRepository {
  CatalogRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<ProductDto>> fetchProducts() async {
    final response = await _client.get<Map<String, dynamic>>('/catalog/products');
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data.map((item) => ProductDto.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<ProductDto> createProduct(
    ProductPayload payload, {
    List<ProductImageUpload>? images,
  }) async {
    final formData = FormData.fromMap(payload.toJson());
    if (images != null && images.isNotEmpty) {
      for (final image in images) {
        formData.files.add(
          MapEntry(
            'images[]',
            MultipartFile.fromBytes(
              image.bytes,
              filename: image.name,
            ),
          ),
        );
      }
    }
    final response = await _client.dio.post<Map<String, dynamic>>(
      '/catalog/products',
      data: formData,
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return ProductDto.fromJson(data);
  }

  Future<ProductDto> updateProduct(
    int id,
    ProductPayload payload, {
    List<ProductImageUpload>? images,
  }) async {
    final formData = FormData.fromMap(payload.toJson());
    if (images != null && images.isNotEmpty) {
      for (final image in images) {
        formData.files.add(
          MapEntry(
            'images[]',
            MultipartFile.fromBytes(
              image.bytes,
              filename: image.name,
            ),
          ),
        );
      }
    }
    final response = await _client.dio.post<Map<String, dynamic>>(
      '/catalog/products/$id',
      data: formData,
      queryParameters: {'_method': 'PUT'},
    );
    final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    return ProductDto.fromJson(data);
  }

  Future<void> deleteProduct(int id) async {
    await _client.delete('/catalog/products/$id');
  }
}

