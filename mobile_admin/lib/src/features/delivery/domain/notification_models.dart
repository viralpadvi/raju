class NotificationDto {
  NotificationDto({
    required this.id,
    required this.type,
    required this.title,
    required this.message,
    this.orderId,
    this.orderNumber,
    required this.isRead,
    required this.createdAt,
    this.readAt,
    this.data,
  });

  factory NotificationDto.fromJson(Map<String, dynamic> json) {
    return NotificationDto(
      id: json['id'] as int? ?? 0,
      type: json['type'] as String? ?? 'info',
      title: json['title'] as String? ?? '',
      message: json['message'] as String? ?? '',
      orderId: json['order_id'] as int?,
      orderNumber: json['order_number'] as String?,
      isRead: json['is_read'] as bool? ?? false,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'] as String)
          : DateTime.now(),
      readAt: json['read_at'] != null
          ? DateTime.tryParse(json['read_at'] as String)
          : null,
      data: json['data'] as Map<String, dynamic>?,
    );
  }

  final int id;
  final String type;
  final String title;
  final String message;
  final int? orderId;
  final String? orderNumber;
  final bool isRead;
  final DateTime createdAt;
  final DateTime? readAt;
  final Map<String, dynamic>? data;

  bool get isOrderAssignment => type == 'order_assigned';
  bool get isOrderUpdate => type == 'order_updated';
  bool get isOrderCancelled => type == 'order_cancelled';

  Map<String, dynamic> toJson() => {
        'id': id,
        'type': type,
        'title': title,
        'message': message,
        'order_id': orderId,
        'order_number': orderNumber,
        'is_read': isRead,
        'created_at': createdAt.toIso8601String(),
      };
}

