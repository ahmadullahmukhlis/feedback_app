class OurserviceModel {
  final int id;
  final String title;
  final String description;
  final String? image;
  final String slug;

  OurserviceModel({
    required this.id,
    required this.title,
    required this.description,
    this.image,
    required this.slug,
  });

  factory OurserviceModel.fromJson(Map<String, dynamic> json) {
    return OurserviceModel(
      id: json['id'],
      title: json['title'] ?? '',
      description: json['description'] ?? '',
      image: json['image'],
      slug: json['slug'] ?? '',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'description': description,
      'image': image,
      'slug': slug,
    };
  }
}
