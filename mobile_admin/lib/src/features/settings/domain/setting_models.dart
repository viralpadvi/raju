class SettingDto {
  SettingDto({
    required this.key,
    required this.value,
    this.type = 'string',
  });

  factory SettingDto.fromJson(Map<String, dynamic> json) {
    return SettingDto(
      key: json['key'] as String? ?? '',
      value: json['value'],
      type: json['type'] as String? ?? 'string',
    );
  }

  final String key;
  final dynamic value;
  final String type;

  Map<String, dynamic> toJson() => {
        'key': key,
        'value': value,
        'type': type,
      };
}

class SettingsPayload {
  SettingsPayload({
    this.storeName,
    this.storeEmail,
    this.storePhone,
    this.storeAddress,
    this.currency,
    this.smtpSettings,
    this.paymentSettings,
    this.smsSettings,
  });

  final String? storeName;
  final String? storeEmail;
  final String? storePhone;
  final String? storeAddress;
  final String? currency;
  final Map<String, dynamic>? smtpSettings;
  final Map<String, dynamic>? paymentSettings;
  final Map<String, dynamic>? smsSettings;

  Map<String, dynamic> toJson() {
    final map = <String, dynamic>{};
    if (storeName != null) map['store_name'] = storeName;
    if (storeEmail != null) map['store_email'] = storeEmail;
    if (storePhone != null) map['store_phone'] = storePhone;
    if (storeAddress != null) map['store_address'] = storeAddress;
    if (currency != null) map['currency'] = currency;
    if (smtpSettings != null) map['smtp_settings'] = smtpSettings;
    if (paymentSettings != null) map['payment_settings'] = paymentSettings;
    if (smsSettings != null) map['sms_settings'] = smtpSettings;
    return map;
  }
}
