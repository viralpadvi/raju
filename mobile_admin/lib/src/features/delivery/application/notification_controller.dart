import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../data/notification_repository.dart';
import '../domain/notification_models.dart';

final notificationControllerProvider =
    StateNotifierProvider<NotificationController, NotificationState>((ref) {
  final repository = ref.watch(notificationRepositoryProvider);
  final controller = NotificationController(repository: repository);
  controller.bootstrap();
  return controller;
});

class NotificationController extends StateNotifier<NotificationState> {
  NotificationController({required NotificationRepository repository})
      : _repository = repository,
        super(const NotificationState.initial());

  final NotificationRepository _repository;

  Future<void> bootstrap() async {
    await refresh();
    await refreshUnreadCount();
  }

  Future<void> refresh({bool unreadOnly = false, String? type}) async {
    state = state.copyWith(isLoading: true, errorMessage: null);
    try {
      final notifications = await _repository.fetchNotifications(
        unreadOnly: unreadOnly,
        type: type,
      );
      state = state.copyWith(isLoading: false, notifications: notifications);
    } catch (error) {
      state = state.copyWith(
        isLoading: false,
        errorMessage: error.toString(),
      );
    }
  }

  Future<void> refreshUnreadCount() async {
    try {
      final count = await _repository.getUnreadCount();
      state = state.copyWith(unreadCount: count);
    } catch (error) {
      // Silently fail for unread count
    }
  }

  Future<bool> markAsRead(int notificationId) async {
    try {
      await _repository.markAsRead(notificationId);
      final notifications = state.notifications
          .map((n) => n.id == notificationId
              ? NotificationDto(
                  id: n.id,
                  type: n.type,
                  title: n.title,
                  message: n.message,
                  orderId: n.orderId,
                  orderNumber: n.orderNumber,
                  isRead: true,
                  createdAt: n.createdAt,
                  readAt: DateTime.now(),
                  data: n.data,
                )
              : n)
          .toList();
      state = state.copyWith(notifications: notifications);
      await refreshUnreadCount();
      return true;
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
      return false;
    }
  }

  Future<bool> markAllAsRead() async {
    try {
      await _repository.markAllAsRead();
      final notifications = state.notifications
          .map((n) => NotificationDto(
                id: n.id,
                type: n.type,
                title: n.title,
                message: n.message,
                orderId: n.orderId,
                orderNumber: n.orderNumber,
                isRead: true,
                createdAt: n.createdAt,
                readAt: DateTime.now(),
                data: n.data,
              ))
          .toList();
      state = state.copyWith(notifications: notifications, unreadCount: 0);
      return true;
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
      return false;
    }
  }

  Future<bool> deleteNotification(int notificationId) async {
    try {
      await _repository.deleteNotification(notificationId);
      final notifications =
          state.notifications.where((n) => n.id != notificationId).toList();
      state = state.copyWith(notifications: notifications);
      await refreshUnreadCount();
      return true;
    } catch (error) {
      state = state.copyWith(errorMessage: error.toString());
      return false;
    }
  }
}

class NotificationState {
  const NotificationState({
    required this.isLoading,
    required this.notifications,
    required this.unreadCount,
    required this.errorMessage,
  });

  const NotificationState.initial()
      : isLoading = false,
        notifications = const [],
        unreadCount = 0,
        errorMessage = null;

  final bool isLoading;
  final List<NotificationDto> notifications;
  final int unreadCount;
  final String? errorMessage;

  NotificationState copyWith({
    bool? isLoading,
    List<NotificationDto>? notifications,
    int? unreadCount,
    String? errorMessage,
  }) {
    return NotificationState(
      isLoading: isLoading ?? this.isLoading,
      notifications: notifications ?? this.notifications,
      unreadCount: unreadCount ?? this.unreadCount,
      errorMessage: errorMessage,
    );
  }
}

