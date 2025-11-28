import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../core/network/api_client.dart';
import '../domain/notification_models.dart';

final notificationRepositoryProvider = Provider<NotificationRepository>((ref) {
  return NotificationRepository(client: ref.watch(apiClientProvider));
});

class NotificationRepository {
  NotificationRepository({required ApiClient client}) : _client = client;

  final ApiClient _client;

  Future<List<NotificationDto>> fetchNotifications({
    bool? unreadOnly,
    String? type,
    int? limit,
  }) async {
    final queryParams = <String, dynamic>{};
    if (unreadOnly == true) {
      queryParams['unread_only'] = true;
    }
    if (type != null && type.isNotEmpty) {
      queryParams['type'] = type;
    }
    if (limit != null) {
      queryParams['limit'] = limit;
    }

    final response = await _client.get<Map<String, dynamic>>(
      '/delivery/notifications',
      query: queryParams,
    );
    final data = response.data?['data'] as List<dynamic>? ?? [];
    return data
        .map((item) => NotificationDto.fromJson(item as Map<String, dynamic>))
        .toList();
  }

  Future<int> getUnreadCount() async {
    final response = await _client.get<Map<String, dynamic>>(
      '/delivery/notifications/unread-count',
    );
    return response.data?['count'] as int? ?? 0;
  }

  Future<void> markAsRead(int notificationId) async {
    await _client.put<Map<String, dynamic>>(
      '/delivery/notifications/$notificationId/read',
    );
  }

  Future<void> markAllAsRead() async {
    await _client.post<Map<String, dynamic>>(
      '/delivery/notifications/mark-all-read',
    );
  }

  Future<void> deleteNotification(int notificationId) async {
    await _client.delete<Map<String, dynamic>>(
      '/delivery/notifications/$notificationId',
    );
  }
}

