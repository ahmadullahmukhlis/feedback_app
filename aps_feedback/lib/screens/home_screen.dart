import 'dart:convert';
import 'package:aps_feedback/generated/l10n.dart';
import 'package:aps_feedback/models/news.dart';
import 'package:aps_feedback/screens/news_details_screen.dart';
import 'package:aps_feedback/services/news_services.dart';
import 'package:flutter/material.dart';
import 'package:aps_feedback/layouts/main_layout.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  List<Map<String, dynamic>> newsItems = [];
  bool isLoading = true;
  Locale? _currentLocale;

  // General news JSON


  @override
  void initState() {
    super.initState();
    _loadNews();
  }
  @override
  void didChangeDependencies() {
    super.didChangeDependencies();

    final locale = Localizations.localeOf(context);
    if (_currentLocale != locale) {
      _currentLocale = locale;
      _loadNews(); // reload news when language changes
    }
  }

  Future<void> _loadNews() async {
    setState(() => isLoading = true);

    try {
      final response = await NewsServices.getNews();

      // Make sure to access the actual data
      final List<dynamic> apidata = response; // if using Dio


      setState(() {
        newsItems = apidata
            .map((item) => News.fromJson(item).toJson())
            .toList();
        isLoading = false;
      });
    } catch (e) {
      print('Error: $e');
      setState(() => isLoading = false);
    }
  }


  Future<void> _refreshNews() async {
    setState(() => isLoading = true);
    await _loadNews();
  }


  Widget _buildNewsCard(Map<String, dynamic> news) {
    return Card(
      margin: const EdgeInsets.symmetric(vertical: 8, horizontal: 16),
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: InkWell(
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(
              builder: (_) => NewsDetailScreen(news: news),
            ),
          );
        },

        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Image
            if (news['image'] != null && news['image']
                .toString()
                .isNotEmpty)
              ClipRRect(
                borderRadius: const BorderRadius.vertical(
                    top: Radius.circular(12)),
                child: Image.network(
                  news['image'],
                  height: 180,
                  width: double.infinity,
                  fit: BoxFit.cover,
                  errorBuilder: (context, error, stackTrace) =>
                      Container(height: 180, color: Colors.grey[300]),
                ),
              ),
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Title
                  Text(
                    news['title'],
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: news['isRead']
                          ? FontWeight.normal
                          : FontWeight.bold,

                    ),
                  ),
                  const SizedBox(height: 8),
                  // Description
                  Text(
                    news['content'],
                    style: TextStyle(
                      fontSize: 14,
                      color: Colors.grey[600],
                    ),
                    maxLines: 3,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 12),
                  // Footer: category and created_at
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(
                            horizontal: 8, vertical: 4),
                        decoration: BoxDecoration(
                          color: Colors.blue.withOpacity(0.1),
                          borderRadius: BorderRadius.circular(6),
                        ),
                        child: Text(
                          news['category'],
                          style: const TextStyle(
                            color: Colors.blue,
                            fontWeight: FontWeight.bold,
                            fontSize: 12,
                          ),
                        ),
                      ),
                      Text(
                        news['created_at'].toString().split("T")[0],
                        style: TextStyle(
                          color: Colors.grey[500],
                          fontSize: 12,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            )
          ],
        ),
      ),
    );
  }


  @override
  Widget build(BuildContext context) {
    final List newsList = newsItems ?? [];

    return MainLayout(
      title: "Afghan Payment System",
      subtitle: S.of(context).home,
      currentIndex: 0,
      child: RefreshIndicator(
        onRefresh: _refreshNews,
        child: isLoading
            ? const Center(child: CircularProgressIndicator())
            : newsList.isEmpty
            ? ListView( // 👈 REQUIRED for RefreshIndicator
          children:  [
            SizedBox(height: 320),
            Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
               const   Icon(Icons.newspaper,
                      size: 64, color: Colors.grey),
                const  SizedBox(height: 12),
                  Text(
                  S.of(context).no_news_available,
                    style: const TextStyle(
                        color: Colors.grey, fontSize: 16),
                  ),
                ],
              ),
            ),
          ],
        )
            : ListView.builder(
          itemCount: newsList.length,
          itemBuilder: (context, index) {
            final news = newsList[index];
            if (news == null) return const SizedBox.shrink();
            return _buildNewsCard(news);
          },
        ),
      ),
    );
  }
}
