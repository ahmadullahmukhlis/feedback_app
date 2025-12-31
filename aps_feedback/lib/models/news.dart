class News {
  final int id;
  final String title;
  final String content;
  final String category;
  final bool isRead;
  final String? image;

  News({
    required this.id,
    required this.title,
    required this.content,
    required this.category,
    required this.isRead,
    this.image,
  });

  factory News.fromJson(Map<String, dynamic> json) {
    return News(
      id: json['id'],
      title: json['title'],
      content: json['content'],
      category: json['category'] ?? '',
      isRead: json['isRead'] ?? false,
      image: json['image'],
    );
  }

}
extension NewsExtension on News {
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'content': content,
      'category': category,
      'isRead': isRead,
      'image': image,
      'created_at': DateTime.now().toIso8601String(), // you can replace with your actual created_at
    };
  }
}
