class ProjectDto {
  ProjectDto({
    required this.id,
    required this.name,
    required this.slug,
    this.client,
    this.clientLogo,
    this.clientWebsite,
    this.description,
    this.details,
    this.specification = const [],
    this.images = const [],
    this.videos = const [],
    this.youtubeLink,
    this.facebookLink,
    this.twitterLink,
    this.instagramLink,
    this.linkedinLink,
    this.githubLink,
    this.websiteLink,
    this.startDate,
    this.endDate,
    required this.status,
    required this.priority,
    this.budget,
    this.category,
    this.tags = const [],
    required this.isFeatured,
    required this.isActive,
    required this.sortOrder,
    this.metaTitle,
    this.metaDescription,
    this.metaKeywords,
    this.createdAt,
    this.updatedAt,
  });

  factory ProjectDto.fromJson(Map<String, dynamic> json) {
    return ProjectDto(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String? ?? '',
      client: json['client'] as String?,
      clientLogo: json['client_logo'] as String?,
      clientWebsite: json['client_website'] as String?,
      description: json['description'] as String?,
      details: json['details'] as String?,
      specification: (json['specification'] as List<dynamic>?)
              ?.map((e) => Map<String, dynamic>.from(e as Map))
              .toList() ??
          const [],
      images: (json['images'] as List<dynamic>?)
              ?.map((e) => e as String)
              .toList() ??
          const [],
      videos: (json['videos'] as List<dynamic>?)
              ?.map((e) => e as String)
              .toList() ??
          const [],
      youtubeLink: json['youtube_link'] as String?,
      facebookLink: json['facebook_link'] as String?,
      twitterLink: json['twitter_link'] as String?,
      instagramLink: json['instagram_link'] as String?,
      linkedinLink: json['linkedin_link'] as String?,
      githubLink: json['github_link'] as String?,
      websiteLink: json['website_link'] as String?,
      startDate: json['start_date'] != null
          ? DateTime.tryParse(json['start_date'] as String)
          : null,
      endDate: json['end_date'] != null
          ? DateTime.tryParse(json['end_date'] as String)
          : null,
      status: json['status'] as String? ?? 'pending',
      priority: json['priority'] as String? ?? 'medium',
      budget: json['budget'] != null ? (json['budget'] as num?)?.toDouble() : null,
      category: json['category'] as String?,
      tags: (json['tags'] as List<dynamic>?)?.map((e) => e as String).toList() ?? const [],
      isFeatured: json['is_featured'] as bool? ?? false,
      isActive: json['is_active'] as bool? ?? true,
      sortOrder: json['sort_order'] as int? ?? 0,
      metaTitle: json['meta_title'] as String?,
      metaDescription: json['meta_description'] as String?,
      metaKeywords: json['meta_keywords'] as String?,
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'] as String)
          : null,
      updatedAt: json['updated_at'] != null
          ? DateTime.tryParse(json['updated_at'] as String)
          : null,
    );
  }

  final int id;
  final String name;
  final String slug;
  final String? client;
  final String? clientLogo;
  final String? clientWebsite;
  final String? description;
  final String? details;
  final List<Map<String, dynamic>> specification;
  final List<String> images;
  final List<String> videos;
  final String? youtubeLink;
  final String? facebookLink;
  final String? twitterLink;
  final String? instagramLink;
  final String? linkedinLink;
  final String? githubLink;
  final String? websiteLink;
  final DateTime? startDate;
  final DateTime? endDate;
  final String status;
  final String priority;
  final double? budget;
  final String? category;
  final List<String> tags;
  final bool isFeatured;
  final bool isActive;
  final int sortOrder;
  final String? metaTitle;
  final String? metaDescription;
  final String? metaKeywords;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  String get statusLabel {
    switch (status) {
      case 'completed':
        return 'Completed';
      case 'in_progress':
        return 'In Progress';
      case 'on_hold':
        return 'On Hold';
      case 'cancelled':
        return 'Cancelled';
      default:
        return 'Pending';
    }
  }

  String get priorityLabel {
    switch (priority) {
      case 'urgent':
        return 'Urgent';
      case 'high':
        return 'High';
      case 'low':
        return 'Low';
      default:
        return 'Medium';
    }
  }

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'slug': slug,
        'client': client,
        'description': description,
        'status': status,
        'priority': priority,
      };
}

class ProjectPayload {
  ProjectPayload({
    required this.name,
    this.slug,
    this.client,
    this.clientWebsite,
    this.description,
    this.details,
    this.specification,
    this.youtubeLink,
    this.facebookLink,
    this.twitterLink,
    this.instagramLink,
    this.linkedinLink,
    this.githubLink,
    this.websiteLink,
    this.startDate,
    this.endDate,
    this.status = 'pending',
    this.priority = 'medium',
    this.budget,
    this.category,
    this.tags,
    this.isFeatured = false,
    this.isActive = true,
    this.sortOrder = 0,
    this.metaTitle,
    this.metaDescription,
    this.metaKeywords,
  });

  final String name;
  final String? slug;
  final String? client;
  final String? clientWebsite;
  final String? description;
  final String? details;
  final List<Map<String, dynamic>>? specification;
  final String? youtubeLink;
  final String? facebookLink;
  final String? twitterLink;
  final String? instagramLink;
  final String? linkedinLink;
  final String? githubLink;
  final String? websiteLink;
  final DateTime? startDate;
  final DateTime? endDate;
  final String status;
  final String priority;
  final double? budget;
  final String? category;
  final List<String>? tags;
  final bool isFeatured;
  final bool isActive;
  final int sortOrder;
  final String? metaTitle;
  final String? metaDescription;
  final String? metaKeywords;

  Map<String, dynamic> toJson() {
    final map = <String, dynamic>{
      'name': name,
      'status': status,
      'priority': priority,
      'is_featured': isFeatured,
      'is_active': isActive,
      'sort_order': sortOrder,
    };

    if (slug != null) map['slug'] = slug;
    if (client != null) map['client'] = client;
    if (clientWebsite != null) map['client_website'] = clientWebsite;
    if (description != null) map['description'] = description;
    if (details != null) map['details'] = details;
    if (specification != null && specification!.isNotEmpty) map['specification'] = specification;
    if (youtubeLink != null) map['youtube_link'] = youtubeLink;
    if (facebookLink != null) map['facebook_link'] = facebookLink;
    if (twitterLink != null) map['twitter_link'] = twitterLink;
    if (instagramLink != null) map['instagram_link'] = instagramLink;
    if (linkedinLink != null) map['linkedin_link'] = linkedinLink;
    if (githubLink != null) map['github_link'] = githubLink;
    if (websiteLink != null) map['website_link'] = websiteLink;
    if (startDate != null) map['start_date'] = startDate!.toIso8601String().split('T')[0];
    if (endDate != null) map['end_date'] = endDate!.toIso8601String().split('T')[0];
    if (budget != null) map['budget'] = budget;
    if (category != null) map['category'] = category;
    if (tags != null && tags!.isNotEmpty) map['tags'] = tags;
    if (metaTitle != null) map['meta_title'] = metaTitle;
    if (metaDescription != null) map['meta_description'] = metaDescription;
    if (metaKeywords != null) map['meta_keywords'] = metaKeywords;

    return map;
  }
}

