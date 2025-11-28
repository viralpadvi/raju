import 'package:dio/dio.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:image_picker/image_picker.dart';

import '../../../core/network/api_client.dart';
import '../domain/brand_models.dart';

final brandRepositoryProvider = Provider<BrandRepository>((ref) {
  return BrandRepository(client: ref.watch(apiClientProvider));
});

class BrandRepository {
  BrandRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<BrandDto>> fetchBrands({String? search, bool? status}) async {
    final queryParams = <String, dynamic>{};
    if (search != null && search.isNotEmpty) {
      queryParams['search'] = search;
    }
    if (status != null) {
      queryParams['status'] = status;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/catalog/brands',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => BrandDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<BrandDto> createBrand(BrandPayload payload, {XFile? logoFile}) async {
    if (logoFile != null) {
      final formData = FormData.fromMap(payload.toJson());
      final bytes = await logoFile.readAsBytes();
      formData.files.add(
        MapEntry(
          'logo',
          MultipartFile.fromBytes(
            bytes,
            filename: logoFile.name,
          ),
        ),
      );
      final response = await _client.dio.post<Map<String, dynamic>>(
        '/catalog/brands',
        data: formData,
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return BrandDto.fromJson(data);
    } else {
      final response = await _client.post<Map<String, dynamic>>(
        '/catalog/brands',
        data: payload.toJson(),
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return BrandDto.fromJson(data);
    }
  }

  Future<BrandDto> updateBrand(int id, BrandPayload payload, {XFile? logoFile}) async {
    if (logoFile != null) {
      final formData = FormData.fromMap(payload.toJson());
      final bytes = await logoFile.readAsBytes();
      formData.files.add(
        MapEntry(
          'logo',
          MultipartFile.fromBytes(
            bytes,
            filename: logoFile.name,
          ),
        ),
      );
      final response = await _client.dio.post<Map<String, dynamic>>(
        '/catalog/brands/$id',
        data: formData,
        queryParameters: {'_method': 'PUT'},
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return BrandDto.fromJson(data);
    } else {
      final response = await _client.put<Map<String, dynamic>>(
        '/catalog/brands/$id',
        data: payload.toJson(),
      );
      final data = response.data?['data'] as Map<String, dynamic>? ?? {};
      return BrandDto.fromJson(data);
    }
  }

  Future<void> deleteBrand(int id) async {
    await _client.delete('/catalog/brands/$id');
  }
}

