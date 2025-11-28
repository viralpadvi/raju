import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/shift_models.dart';

// Note: Shift API needs to be implemented in the backend
// Expected endpoints:
// GET    /pos/shifts - List all shifts
// POST   /pos/shifts - Start a new shift
// GET    /pos/shifts/{id} - Get shift details
// PUT    /pos/shifts/{id} - Update shift
// POST   /pos/shifts/{id}/close - Close shift
// DELETE /pos/shifts/{id} - Delete shift

final shiftRepositoryProvider = Provider<ShiftRepository>((ref) {
  return ShiftRepository(client: ref.watch(apiClientProvider));
});

class ShiftRepository {
  ShiftRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<ShiftDto>> fetchShifts({
    int? registerId,
    String? status,
    DateTime? dateFrom,
    DateTime? dateTo,
  }) async {
    // TODO: Uncomment when API is ready
    // final queryParams = <String, dynamic>{};
    // if (registerId != null) {
    //   queryParams['register_id'] = registerId;
    // }
    // if (status != null) {
    //   queryParams['status'] = status;
    // }
    // if (dateFrom != null) {
    //   queryParams['date_from'] = dateFrom.toIso8601String().split('T')[0];
    // }
    // if (dateTo != null) {
    //   queryParams['date_to'] = dateTo.toIso8601String().split('T')[0];
    // }
    //
    // final response = await _client.get<Map<String, dynamic>>(
    //   '/pos/shifts',
    //   queryParameters: queryParams,
    // );
    // final data = response.data?['data'] as List<dynamic>? ?? [];
    // return data
    //     .map((item) => ShiftDto.fromJson(item as Map<String, dynamic>))
    //     .toList();
    
    // Placeholder - returns empty list until API is ready
    return [];
  }

  Future<ShiftDto> startShift(ShiftPayload payload) async {
    // TODO: Uncomment when API is ready
    // final response = await _client.post<Map<String, dynamic>>(
    //   '/pos/shifts',
    //   data: payload.toJson(),
    // );
    // final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    // return ShiftDto.fromJson(data);
    
    throw Exception('Shift API not yet implemented. Please create the backend API first.');
  }

  Future<ShiftDto> closeShift(int id, {double? endingCash, String? notes}) async {
    // TODO: Uncomment when API is ready
    // final response = await _client.post<Map<String, dynamic>>(
    //   '/pos/shifts/$id/close',
    //   data: {
    //     if (endingCash != null) 'ending_cash': endingCash,
    //     if (notes != null) 'notes': notes,
    //   },
    // );
    // final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    // return ShiftDto.fromJson(data);
    
    throw Exception('Shift API not yet implemented.');
  }

  Future<ShiftDto> updateShift(int id, {double? endingCash, String? notes}) async {
    // TODO: Uncomment when API is ready
    // final response = await _client.put<Map<String, dynamic>>(
    //   '/pos/shifts/$id',
    //   data: {
    //     if (endingCash != null) 'ending_cash': endingCash,
    //     if (notes != null) 'notes': notes,
    //   },
    // );
    // final data = response.data?['data'] as Map<String, dynamic>? ?? {};
    // return ShiftDto.fromJson(data);
    
    throw Exception('Shift API not yet implemented.');
  }

  Future<void> deleteShift(int id) async {
    // TODO: Uncomment when API is ready
    // await _client.delete('/pos/shifts/$id');
    
    throw Exception('Shift API not yet implemented.');
  }
}

