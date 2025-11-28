class CustomerDto {
  CustomerDto({
    required this.id,
    required this.firstName,
    this.lastName,
    this.email,
    this.phone,
    this.dateOfBirth,
    this.gender,
    this.address,
    required this.isActive,
    this.newsletterSubscribed = false,
    this.salesCount,
    this.createdAt,
    this.updatedAt,
  });

  factory CustomerDto.fromJson(Map<String, dynamic> json) {
    return CustomerDto(
      id: json['id'] as int? ?? 0,
      firstName: json['first_name'] as String? ?? '',
      lastName: json['last_name'] as String?,
      email: json['email'] as String?,
      phone: json['phone'] as String?,
      dateOfBirth: json['date_of_birth'] != null
          ? DateTime.tryParse(json['date_of_birth'] as String)
          : null,
      gender: json['gender'] as String?,
      address: json['address'] as String?,
      isActive: json['is_active'] as bool? ?? true,
      newsletterSubscribed: json['newsletter_subscribed'] as bool? ?? false,
      salesCount: json['sales_count'] as int?,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'] as String)
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.tryParse(json['updated_at'] as String)
          : null,
    );
  }

  final int id;
  final String firstName;
  final String? lastName;
  final String? email;
  final String? phone;
  final DateTime? dateOfBirth;
  final String? gender;
  final String? address;
  final bool isActive;
  final bool newsletterSubscribed;
  final int? salesCount;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get fullName => lastName != null ? '$firstName $lastName' : firstName;
  String get displayName => firstName.isNotEmpty ? firstName : (email ?? 'Unknown');

  Map<String, dynamic> toJson() => {
        'id': id,
        'first_name': firstName,
        'last_name': lastName,
        'email': email,
        'phone': phone,
        'date_of_birth': dateOfBirth?.toIso8601String().split('T')[0],
        'gender': gender,
        'address': address,
        'is_active': isActive,
        'newsletter_subscribed': newsletterSubscribed,
      };
}

class CustomerPayload {
  CustomerPayload({
    required this.firstName,
    this.lastName,
    this.email,
    this.phone,
    this.dateOfBirth,
    this.gender,
    this.address,
    this.password,
    this.isActive = true,
    this.newsletterSubscribed = false,
  });

  final String firstName;
  final String? lastName;
  final String? email;
  final String? phone;
  final DateTime? dateOfBirth;
  final String? gender;
  final String? address;
  final String? password;
  final bool isActive;
  final bool newsletterSubscribed;

  Map<String, dynamic> toJson() => {
        'first_name': firstName,
        if (lastName != null) 'last_name': lastName,
        if (email != null) 'email': email,
        if (phone != null) 'phone': phone,
        if (dateOfBirth != null) 'date_of_birth': dateOfBirth!.toIso8601String().split('T')[0],
        if (gender != null) 'gender': gender,
        if (address != null) 'address': address,
        if (password != null) 'password': password,
        'is_active': isActive,
        'newsletter_subscribed': newsletterSubscribed,
      };
}

