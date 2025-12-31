<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguageWordsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('language_words')->delete();
        
        \DB::table('language_words')->insert(array (
            0 => 
            array (
                'id' => 5,
                'language_id' => 1,
                'word' => 'Home page',
                'translation' => 'صفحه نخست',
                'created_at' => '2024-04-12 19:26:00',
                'updated_at' => '2024-04-12 19:26:00',
            ),
            1 => 
            array (
                'id' => 6,
                'language_id' => 1,
                'word' => 'Shortcuts',
                'translation' => 'لینک های پرکاربرد',
                'created_at' => '2024-04-12 19:29:31',
                'updated_at' => '2024-04-12 19:29:31',
            ),
            2 => 
            array (
                'id' => 7,
                'language_id' => 1,
                'word' => 'Notifications',
                'translation' => 'اطلاعیه ها',
                'created_at' => '2024-04-12 19:32:02',
                'updated_at' => '2024-04-12 19:32:02',
            ),
            3 => 
            array (
                'id' => 8,
                'language_id' => 1,
                'word' => 'Languages',
                'translation' => 'زبان ها',
                'created_at' => '2024-04-12 19:32:23',
                'updated_at' => '2024-04-12 19:32:23',
            ),
            4 => 
            array (
                'id' => 9,
                'language_id' => 1,
                'word' => 'Settings',
                'translation' => 'تنظیمات',
                'created_at' => '2024-04-12 19:33:24',
                'updated_at' => '2024-04-12 19:33:24',
            ),
            5 => 
            array (
                'id' => 10,
                'language_id' => 1,
                'word' => 'POS',
                'translation' => 'فروشات',
                'created_at' => '2024-04-12 19:33:44',
                'updated_at' => '2024-04-12 19:33:44',
            ),
            6 => 
            array (
                'id' => 11,
                'language_id' => 1,
                'word' => 'Profile',
                'translation' => 'مشخصات شما',
                'created_at' => '2024-04-12 19:34:16',
                'updated_at' => '2024-04-12 19:34:16',
            ),
            7 => 
            array (
                'id' => 12,
                'language_id' => 1,
                'word' => 'Total products',
                'translation' => 'تعداد تمام اجناس',
                'created_at' => '2024-04-12 19:35:04',
                'updated_at' => '2024-04-12 19:35:04',
            ),
            8 => 
            array (
                'id' => 13,
                'language_id' => 1,
                'word' => 'Total purchases',
                'translation' => 'تعداد تمام خرید ها',
                'created_at' => '2024-04-12 19:35:30',
                'updated_at' => '2024-04-12 19:35:30',
            ),
            9 => 
            array (
                'id' => 14,
                'language_id' => 1,
                'word' => 'Total sales',
                'translation' => 'تعداد تمام فروشات',
                'created_at' => '2024-04-12 19:35:48',
                'updated_at' => '2024-04-12 19:35:48',
            ),
            10 => 
            array (
                'id' => 15,
                'language_id' => 1,
                'word' => 'Total sales return',
                'translation' => 'تعداد برگشتی فروشات',
                'created_at' => '2024-04-12 19:36:25',
                'updated_at' => '2024-04-12 19:36:25',
            ),
            11 => 
            array (
                'id' => 16,
                'language_id' => 1,
                'word' => 'Total customers',
                'translation' => 'تعداد مشتری ها',
                'created_at' => '2024-04-12 19:48:43',
                'updated_at' => '2024-04-12 19:48:43',
            ),
            12 => 
            array (
                'id' => 17,
                'language_id' => 1,
                'word' => 'Total suppliers',
                'translation' => 'تعداد تامین کنندگان',
                'created_at' => '2024-04-12 19:50:08',
                'updated_at' => '2024-04-12 19:50:08',
            ),
            13 => 
            array (
                'id' => 18,
                'language_id' => 1,
                'word' => 'Total borrowers',
                'translation' => 'تعداد معاملات قرضداری',
                'created_at' => '2024-04-12 19:51:00',
                'updated_at' => '2024-04-12 19:51:00',
            ),
            14 => 
            array (
                'id' => 19,
                'language_id' => 1,
                'word' => 'Total expired products',
                'translation' => 'تعداد تمام اجناس انقضا شده',
                'created_at' => '2024-04-12 19:55:58',
                'updated_at' => '2024-04-12 19:55:58',
            ),
            15 => 
            array (
                'id' => 20,
                'language_id' => 1,
                'word' => 'Total purchase return',
                'translation' => 'تعداد تمام خرید ها برگشتی',
                'created_at' => '2024-04-12 19:56:46',
                'updated_at' => '2024-04-12 19:56:46',
            ),
            16 => 
            array (
                'id' => 21,
                'language_id' => 1,
                'word' => 'Total system users',
                'translation' => 'تعداد یوزر های سیستم',
                'created_at' => '2024-04-12 19:57:21',
                'updated_at' => '2024-04-12 19:57:21',
            ),
            17 => 
            array (
                'id' => 22,
                'language_id' => 1,
                'word' => 'Total quotations',
                'translation' => 'تعداد کوتیشن ها پرنت شده',
                'created_at' => '2024-04-12 19:58:10',
                'updated_at' => '2024-04-12 19:58:10',
            ),
            18 => 
            array (
                'id' => 23,
                'language_id' => 1,
                'word' => 'Unpaid suppliers',
                'translation' => 'تعداد معملات ناتکمیل تامین کننده ها',
                'created_at' => '2024-04-12 19:58:52',
                'updated_at' => '2024-04-12 19:58:52',
            ),
            19 => 
            array (
                'id' => 24,
                'language_id' => 1,
                'word' => 'This week sales & purchases',
                'translation' => 'خرید و فروش های این هفته',
                'created_at' => '2024-04-12 19:59:38',
                'updated_at' => '2024-04-12 19:59:38',
            ),
            20 => 
            array (
                'id' => 25,
                'language_id' => 1,
                'word' => 'Top selling products',
                'translation' => 'محصولات پرفروش',
                'created_at' => '2024-04-12 20:00:34',
                'updated_at' => '2024-04-12 20:00:34',
            ),
            21 => 
            array (
                'id' => 26,
                'language_id' => 1,
                'word' => 'Top 5 customer',
                'translation' => '5 مشتری برتر',
                'created_at' => '2024-04-12 20:00:54',
                'updated_at' => '2024-04-12 20:01:13',
            ),
            22 => 
            array (
                'id' => 27,
                'language_id' => 1,
                'word' => 'Sales and purchase with returns',
                'translation' => 'خرید و فروش با برگشت',
                'created_at' => '2024-04-12 20:02:04',
                'updated_at' => '2024-04-12 20:02:04',
            ),
            23 => 
            array (
                'id' => 28,
                'language_id' => 1,
                'word' => 'Stock alert',
                'translation' => 'هشدار گدام',
                'created_at' => '2024-04-12 20:02:32',
                'updated_at' => '2024-04-12 20:02:32',
            ),
            24 => 
            array (
                'id' => 29,
                'language_id' => 1,
                'word' => 'Sales',
                'translation' => 'فروشات',
                'created_at' => '2024-04-12 20:04:32',
                'updated_at' => '2024-04-12 20:04:32',
            ),
            25 => 
            array (
                'id' => 30,
                'language_id' => 1,
                'word' => 'Purchases',
                'translation' => 'خرید ها',
                'created_at' => '2024-04-12 20:08:52',
                'updated_at' => '2024-04-12 20:08:52',
            ),
            26 => 
            array (
                'id' => 31,
                'language_id' => 1,
                'word' => 'Code',
                'translation' => 'کود',
                'created_at' => '2024-04-12 20:09:27',
                'updated_at' => '2024-04-12 20:09:27',
            ),
            27 => 
            array (
                'id' => 32,
                'language_id' => 1,
                'word' => 'Product',
                'translation' => 'جنس',
                'created_at' => '2024-04-12 20:09:39',
                'updated_at' => '2024-04-12 20:09:39',
            ),
            28 => 
            array (
                'id' => 33,
                'language_id' => 1,
                'word' => 'Warehouse',
                'translation' => 'گدام',
                'created_at' => '2024-04-12 20:09:55',
                'updated_at' => '2024-04-12 20:09:55',
            ),
            29 => 
            array (
                'id' => 34,
                'language_id' => 1,
                'word' => 'Quantity',
                'translation' => 'مقدار',
                'created_at' => '2024-04-12 20:10:11',
                'updated_at' => '2024-04-12 20:10:11',
            ),
            30 => 
            array (
                'id' => 35,
                'language_id' => 1,
                'word' => 'Alert quantity',
                'translation' => 'تعداد هشدار',
                'created_at' => '2024-04-12 20:10:29',
                'updated_at' => '2024-04-12 20:10:29',
            ),
            31 => 
            array (
                'id' => 36,
                'language_id' => 1,
                'word' => 'Qty',
                'translation' => 'مقدار',
                'created_at' => '2024-04-12 20:10:43',
                'updated_at' => '2024-04-12 20:10:43',
            ),
            32 => 
            array (
                'id' => 37,
                'language_id' => 1,
                'word' => 'Grand total',
                'translation' => 'مقدار حصول شده',
                'created_at' => '2024-04-12 20:11:44',
                'updated_at' => '2024-04-12 20:11:44',
            ),
            33 => 
            array (
                'id' => 38,
                'language_id' => 1,
                'word' => 'Sale return',
                'translation' => 'فروشات برگشتی',
                'created_at' => '2024-04-12 20:14:00',
                'updated_at' => '2024-04-12 20:14:00',
            ),
            34 => 
            array (
                'id' => 39,
                'language_id' => 1,
                'word' => 'Purchase',
                'translation' => 'خرید',
                'created_at' => '2024-04-12 20:14:18',
                'updated_at' => '2024-04-12 20:14:18',
            ),
            35 => 
            array (
                'id' => 40,
                'language_id' => 1,
                'word' => 'Purchase return',
                'translation' => 'خرید های برگشتی',
                'created_at' => '2024-04-12 20:14:35',
                'updated_at' => '2024-04-12 20:14:35',
            ),
            36 => 
            array (
                'id' => 41,
                'language_id' => 1,
                'word' => 'Dashboard',
                'translation' => 'صفحه اصلی',
                'created_at' => '2024-04-12 20:15:29',
                'updated_at' => '2024-04-12 20:15:29',
            ),
            37 => 
            array (
                'id' => 42,
                'language_id' => 1,
                'word' => 'Product management',
                'translation' => 'مدریت اجناس',
                'created_at' => '2024-04-12 20:15:48',
                'updated_at' => '2024-04-12 20:15:48',
            ),
            38 => 
            array (
                'id' => 43,
                'language_id' => 1,
                'word' => 'Adjustments',
                'translation' => 'تنظیم اجناس',
                'created_at' => '2024-04-12 20:16:14',
                'updated_at' => '2024-04-12 20:16:26',
            ),
            39 => 
            array (
                'id' => 44,
                'language_id' => 1,
                'word' => 'Purchase management',
                'translation' => 'مدریت خریداری ها',
                'created_at' => '2024-04-12 20:16:47',
                'updated_at' => '2024-04-12 20:16:47',
            ),
            40 => 
            array (
                'id' => 45,
                'language_id' => 1,
                'word' => 'Sales management',
                'translation' => 'مدریت فروشات',
                'created_at' => '2024-04-12 20:16:59',
                'updated_at' => '2024-04-12 20:16:59',
            ),
            41 => 
            array (
                'id' => 46,
                'language_id' => 1,
                'word' => 'Transfer',
                'translation' => 'انتقالات',
                'created_at' => '2024-04-12 20:17:09',
                'updated_at' => '2024-04-12 20:17:09',
            ),
            42 => 
            array (
                'id' => 47,
                'language_id' => 1,
                'word' => 'Expenses management',
                'translation' => 'مدریت مصارف',
                'created_at' => '2024-04-12 20:17:32',
                'updated_at' => '2024-04-12 20:17:32',
            ),
            43 => 
            array (
                'id' => 48,
                'language_id' => 1,
                'word' => 'Quotations',
                'translation' => 'کوتیشن ها',
                'created_at' => '2024-04-12 20:17:57',
                'updated_at' => '2024-04-12 20:17:57',
            ),
            44 => 
            array (
                'id' => 49,
                'language_id' => 1,
                'word' => 'Reporting',
                'translation' => 'راپور ها',
                'created_at' => '2024-04-12 20:18:09',
                'updated_at' => '2024-04-12 20:18:09',
            ),
            45 => 
            array (
                'id' => 50,
                'language_id' => 1,
                'word' => 'User management',
                'translation' => 'مدریت یوزر ها',
                'created_at' => '2024-04-12 20:18:26',
                'updated_at' => '2024-04-12 20:18:26',
            ),
            46 => 
            array (
                'id' => 51,
                'language_id' => 1,
                'word' => 'Configurations',
                'translation' => 'تنظیمات',
                'created_at' => '2024-04-12 20:18:46',
                'updated_at' => '2024-04-12 20:18:46',
            ),
            47 => 
            array (
                'id' => 52,
                'language_id' => 1,
                'word' => 'Products',
                'translation' => 'اجناس',
                'created_at' => '2024-04-12 20:19:30',
                'updated_at' => '2024-04-12 20:19:30',
            ),
            48 => 
            array (
                'id' => 53,
                'language_id' => 1,
                'word' => 'Product categories',
                'translation' => 'تطبقه بندی اجناس',
                'created_at' => '2024-04-12 20:19:49',
                'updated_at' => '2024-04-12 20:19:49',
            ),
            49 => 
            array (
                'id' => 54,
                'language_id' => 1,
                'word' => 'Product brands',
                'translation' => 'برندهای محصول',
                'created_at' => '2024-04-12 20:20:07',
                'updated_at' => '2024-04-12 20:20:07',
            ),
            50 => 
            array (
                'id' => 55,
                'language_id' => 1,
                'word' => 'Product units',
                'translation' => 'واحد های اجناس',
                'created_at' => '2024-04-12 20:20:32',
                'updated_at' => '2024-04-12 20:20:32',
            ),
            51 => 
            array (
                'id' => 56,
                'language_id' => 1,
                'word' => 'Barcode generator',
                'translation' => 'تولید کننده بارکود',
                'created_at' => '2024-04-12 20:20:48',
                'updated_at' => '2024-04-12 20:20:48',
            ),
            52 => 
            array (
                'id' => 57,
                'language_id' => 1,
                'word' => 'Products list',
                'translation' => 'لیست اجاس',
                'created_at' => '2024-04-12 20:21:39',
                'updated_at' => '2024-04-12 20:22:22',
            ),
            53 => 
            array (
                'id' => 58,
                'language_id' => 1,
                'word' => 'ID',
                'translation' => 'آی دی',
                'created_at' => '2024-04-12 20:22:41',
                'updated_at' => '2024-04-12 20:22:41',
            ),
            54 => 
            array (
                'id' => 59,
                'language_id' => 1,
                'word' => 'Image',
                'translation' => 'عکس',
                'created_at' => '2024-04-12 20:22:50',
                'updated_at' => '2024-04-12 20:22:50',
            ),
            55 => 
            array (
                'id' => 60,
                'language_id' => 1,
                'word' => 'Name',
                'translation' => 'اسم',
                'created_at' => '2024-04-12 20:23:02',
                'updated_at' => '2024-04-12 20:23:02',
            ),
            56 => 
            array (
                'id' => 61,
                'language_id' => 1,
                'word' => 'Category',
                'translation' => 'دسته بندی',
                'created_at' => '2024-04-12 20:23:25',
                'updated_at' => '2024-04-12 20:23:25',
            ),
            57 => 
            array (
                'id' => 62,
                'language_id' => 1,
                'word' => 'Brand',
                'translation' => 'برند',
                'created_at' => '2024-04-12 20:23:35',
                'updated_at' => '2024-04-12 20:23:46',
            ),
            58 => 
            array (
                'id' => 63,
                'language_id' => 1,
                'word' => 'Created by',
                'translation' => 'ایجاد شده توسط',
                'created_at' => '2024-04-12 20:24:13',
                'updated_at' => '2024-04-12 20:24:13',
            ),
            59 => 
            array (
                'id' => 64,
                'language_id' => 1,
                'word' => 'Expiry date',
                'translation' => 'تاریخ انقضا',
                'created_at' => '2024-04-12 20:24:24',
                'updated_at' => '2024-04-12 20:24:24',
            ),
            60 => 
            array (
                'id' => 65,
                'language_id' => 1,
                'word' => 'Created at',
                'translation' => 'تارخ ایجاد شده',
                'created_at' => '2024-04-12 20:24:40',
                'updated_at' => '2024-04-12 20:24:40',
            ),
            61 => 
            array (
                'id' => 66,
                'language_id' => 1,
                'word' => 'Status',
                'translation' => 'حالت',
                'created_at' => '2024-04-12 20:24:59',
                'updated_at' => '2024-04-12 20:24:59',
            ),
            62 => 
            array (
                'id' => 67,
                'language_id' => 1,
                'word' => 'Search',
                'translation' => 'جستجو',
                'created_at' => '2024-04-12 20:25:31',
                'updated_at' => '2024-04-12 20:25:31',
            ),
            63 => 
            array (
                'id' => 68,
                'language_id' => 1,
                'word' => 'Add new product',
                'translation' => 'اضافه کردن جنس جدید',
                'created_at' => '2024-04-12 20:26:08',
                'updated_at' => '2024-04-12 20:26:08',
            ),
            64 => 
            array (
                'id' => 69,
                'language_id' => 1,
                'word' => 'Loading',
                'translation' => 'در حال کار',
                'created_at' => '2024-04-12 20:26:23',
                'updated_at' => '2024-04-12 20:26:23',
            ),
            65 => 
            array (
                'id' => 70,
                'language_id' => 1,
                'word' => 'Filter',
                'translation' => 'فلتر',
                'created_at' => '2024-04-12 20:26:37',
                'updated_at' => '2024-04-12 20:26:37',
            ),
            66 => 
            array (
                'id' => 71,
                'language_id' => 1,
                'word' => 'Columns',
                'translation' => 'ستون ها',
                'created_at' => '2024-04-12 20:27:00',
                'updated_at' => '2024-04-12 20:27:00',
            ),
            67 => 
            array (
                'id' => 72,
                'language_id' => 1,
                'word' => 'Print',
                'translation' => 'پرنت',
                'created_at' => '2024-04-12 20:27:17',
                'updated_at' => '2024-04-12 20:27:17',
            ),
            68 => 
            array (
                'id' => 73,
                'language_id' => 1,
                'word' => 'Refresh',
                'translation' => 'بروز ساختن',
                'created_at' => '2024-04-12 20:27:39',
                'updated_at' => '2024-04-12 20:27:39',
            ),
            69 => 
            array (
                'id' => 74,
                'language_id' => 1,
                'word' => 'Download',
                'translation' => 'دانلود',
                'created_at' => '2024-04-12 20:27:48',
                'updated_at' => '2024-04-12 20:27:48',
            ),
            70 => 
            array (
                'id' => 75,
                'language_id' => 1,
                'word' => 'Edit record',
                'translation' => 'اپدیت کردن',
                'created_at' => '2024-04-12 20:28:53',
                'updated_at' => '2024-04-12 20:28:53',
            ),
            71 => 
            array (
                'id' => 76,
                'language_id' => 1,
                'word' => 'Delete record',
                'translation' => 'حذف کردن',
                'created_at' => '2024-04-12 20:29:10',
                'updated_at' => '2024-04-12 20:29:10',
            ),
            72 => 
            array (
                'id' => 77,
                'language_id' => 1,
                'word' => 'Product form',
                'translation' => 'فورم اضافه کردن اجناس',
                'created_at' => '2024-04-12 20:31:04',
                'updated_at' => '2024-04-12 20:31:04',
            ),
            73 => 
            array (
                'id' => 78,
                'language_id' => 1,
                'word' => 'Images',
                'translation' => 'عکس ها',
                'created_at' => '2024-04-12 20:31:12',
                'updated_at' => '2024-04-12 20:31:12',
            ),
            74 => 
            array (
                'id' => 79,
                'language_id' => 1,
                'word' => 'Categories',
                'translation' => 'دسته بندی ها',
                'created_at' => '2024-04-12 20:31:29',
                'updated_at' => '2024-04-12 20:31:29',
            ),
            75 => 
            array (
                'id' => 80,
                'language_id' => 1,
                'word' => 'Discount',
                'translation' => 'تخفیف',
                'created_at' => '2024-04-12 20:31:45',
                'updated_at' => '2024-04-12 20:31:45',
            ),
            76 => 
            array (
                'id' => 81,
                'language_id' => 1,
                'word' => 'Purchase unit',
                'translation' => 'واحد خرید',
                'created_at' => '2024-04-12 20:32:27',
                'updated_at' => '2024-04-12 20:32:27',
            ),
            77 => 
            array (
                'id' => 82,
                'language_id' => 1,
                'word' => 'Sale unit',
                'translation' => 'واحد فروش',
                'created_at' => '2024-04-12 20:32:36',
                'updated_at' => '2024-04-12 20:32:36',
            ),
            78 => 
            array (
                'id' => 83,
                'language_id' => 1,
                'word' => 'Product unit',
                'translation' => 'واحد جنس',
                'created_at' => '2024-04-12 20:32:57',
                'updated_at' => '2024-04-12 20:32:57',
            ),
            79 => 
            array (
                'id' => 85,
                'language_id' => 1,
                'word' => 'This section is required',
                'translation' => 'این بخش لازم میباشد',
                'created_at' => '2024-04-13 00:10:11',
                'updated_at' => '2024-04-13 00:10:11',
            ),
            80 => 
            array (
                'id' => 86,
                'language_id' => 1,
                'word' => 'Unit conversion cost and price',
                'translation' => 'هزینه و قیمت تبدیل واحد',
                'created_at' => '2024-04-13 00:30:44',
                'updated_at' => '2024-04-13 00:30:44',
            ),
            81 => 
            array (
                'id' => 87,
                'language_id' => 1,
                'word' => 'Unit name',
                'translation' => 'اسم واحد',
                'created_at' => '2024-04-13 00:31:00',
                'updated_at' => '2024-04-13 00:31:00',
            ),
            82 => 
            array (
                'id' => 88,
                'language_id' => 1,
                'word' => 'Unit cost',
                'translation' => 'قیمت تمام شد',
                'created_at' => '2024-04-13 00:31:10',
                'updated_at' => '2024-04-13 00:31:38',
            ),
            83 => 
            array (
                'id' => 89,
                'language_id' => 1,
                'word' => 'Unit price',
                'translation' => 'نرخ فروش',
                'created_at' => '2024-04-13 00:32:07',
                'updated_at' => '2024-04-13 00:32:07',
            ),
            84 => 
            array (
                'id' => 90,
                'language_id' => 1,
                'word' => 'Units',
                'translation' => 'واحد ها',
                'created_at' => '2024-04-13 00:32:23',
                'updated_at' => '2024-04-13 00:32:23',
            ),
            85 => 
            array (
                'id' => 91,
                'language_id' => 1,
                'word' => 'Save',
                'translation' => 'ثبت',
                'created_at' => '2024-04-13 00:32:32',
                'updated_at' => '2024-04-13 00:32:32',
            ),
            86 => 
            array (
                'id' => 92,
                'language_id' => 1,
                'word' => 'Add new unit conversion',
                'translation' => 'تبدیل واحد جدید را اضافه کنید',
                'created_at' => '2024-04-13 00:32:59',
                'updated_at' => '2024-04-13 00:32:59',
            ),
            87 => 
            array (
                'id' => 93,
                'language_id' => 1,
                'word' => 'Updated successfully',
                'translation' => 'موفقانه اپدیت گردید',
                'created_at' => '2024-04-13 00:42:32',
                'updated_at' => '2024-04-13 00:42:32',
            ),
            88 => 
            array (
                'id' => 94,
                'language_id' => 1,
                'word' => 'Are you sure',
                'translation' => 'آیا شما مطمین هستید',
                'created_at' => '2024-04-13 00:43:10',
                'updated_at' => '2024-04-13 00:43:10',
            ),
            89 => 
            array (
                'id' => 95,
                'language_id' => 1,
                'word' => 'Do you really want to delete',
                'translation' => 'آیا شما واقیعت میخواهید آین دیتا ره حذف نمایید',
                'created_at' => '2024-04-13 00:43:43',
                'updated_at' => '2024-04-13 00:43:43',
            ),
            90 => 
            array (
                'id' => 96,
                'language_id' => 1,
                'word' => 'Product details',
                'translation' => 'معلومات کلی جنس',
                'created_at' => '2024-04-13 00:45:23',
                'updated_at' => '2024-04-13 00:45:23',
            ),
            91 => 
            array (
                'id' => 97,
                'language_id' => 1,
                'word' => 'Stock details',
                'translation' => 'معلومات گدام جنس',
                'created_at' => '2024-04-13 00:45:44',
                'updated_at' => '2024-04-13 00:45:44',
            ),
            92 => 
            array (
                'id' => 98,
                'language_id' => 1,
                'word' => 'Product images',
                'translation' => 'عکس های جنس',
                'created_at' => '2024-04-13 00:45:56',
                'updated_at' => '2024-04-13 00:45:56',
            ),
            93 => 
            array (
                'id' => 99,
                'language_id' => 1,
                'word' => 'Upload new image',
                'translation' => 'اضافه کردن عکس جدید',
                'created_at' => '2024-04-13 00:47:40',
                'updated_at' => '2024-04-13 00:47:40',
            ),
            94 => 
            array (
                'id' => 100,
                'language_id' => 1,
                'word' => 'Product reports',
                'translation' => 'راپور های جنس',
                'created_at' => '2024-04-13 00:47:58',
                'updated_at' => '2024-04-13 00:47:58',
            ),
            95 => 
            array (
                'id' => 101,
                'language_id' => 1,
                'word' => 'Edit',
                'translation' => 'ادت',
                'created_at' => '2024-04-13 00:48:06',
                'updated_at' => '2024-04-13 00:48:06',
            ),
            96 => 
            array (
                'id' => 102,
                'language_id' => 1,
                'word' => 'Product unit const and price',
                'translation' => 'قیمت های جنس',
                'created_at' => '2024-04-13 00:48:25',
                'updated_at' => '2024-04-13 00:48:25',
            ),
            97 => 
            array (
                'id' => 103,
                'language_id' => 1,
                'word' => 'Product stock information',
                'translation' => 'معلومات گدام جنس',
                'created_at' => '2024-04-13 00:48:57',
                'updated_at' => '2024-04-13 00:48:57',
            ),
            98 => 
            array (
                'id' => 104,
                'language_id' => 1,
                'word' => 'Available in',
                'translation' => 'موجود است در',
                'created_at' => '2024-04-13 00:49:23',
                'updated_at' => '2024-04-13 00:49:23',
            ),
            99 => 
            array (
                'id' => 105,
                'language_id' => 1,
                'word' => 'Total available qty',
                'translation' => 'مقدار باقی مانده',
                'created_at' => '2024-04-13 00:49:52',
                'updated_at' => '2024-04-13 00:49:52',
            ),
            100 => 
            array (
                'id' => 106,
                'language_id' => 1,
                'word' => 'Stock information',
                'translation' => 'معلومات گدام',
                'created_at' => '2024-04-13 00:50:05',
                'updated_at' => '2024-04-13 00:50:05',
            ),
            101 => 
            array (
                'id' => 107,
                'language_id' => 1,
                'word' => 'Product unit cost and price',
                'translation' => 'قیمت های جنس',
                'created_at' => '2024-04-13 00:50:26',
                'updated_at' => '2024-04-13 00:50:26',
            ),
            102 => 
            array (
                'id' => 108,
                'language_id' => 1,
                'word' => 'List of product categories',
                'translation' => 'لیست طبقه بندی های اجناست',
                'created_at' => '2024-04-13 00:51:36',
                'updated_at' => '2024-04-13 00:51:36',
            ),
            103 => 
            array (
                'id' => 109,
                'language_id' => 1,
                'word' => 'Add category',
                'translation' => 'اضافه نمودن طبقه بندی',
                'created_at' => '2024-04-13 00:51:53',
                'updated_at' => '2024-04-13 00:51:53',
            ),
            104 => 
            array (
                'id' => 110,
                'language_id' => 1,
                'word' => 'Category name',
                'translation' => 'اسم طبقه بندی',
                'created_at' => '2024-04-13 00:52:07',
                'updated_at' => '2024-04-13 00:52:07',
            ),
            105 => 
            array (
                'id' => 111,
                'language_id' => 1,
                'word' => 'Product category form',
                'translation' => 'فورم طبقه بندی اجناس',
                'created_at' => '2024-04-13 00:52:29',
                'updated_at' => '2024-04-13 00:52:29',
            ),
            106 => 
            array (
                'id' => 112,
                'language_id' => 1,
                'word' => 'Add new brand',
                'translation' => 'اظافه کردن کمپنی ها محصولات',
                'created_at' => '2024-04-13 00:53:47',
                'updated_at' => '2024-04-13 00:53:47',
            ),
            107 => 
            array (
                'id' => 113,
                'language_id' => 1,
                'word' => 'Brand name',
                'translation' => 'اسم کمپنی',
                'created_at' => '2024-04-13 00:53:57',
                'updated_at' => '2024-04-13 00:53:57',
            ),
            108 => 
            array (
                'id' => 114,
                'language_id' => 1,
                'word' => 'Brand Form',
                'translation' => 'فورم کامپنی های اجناس',
                'created_at' => '2024-04-13 00:54:27',
                'updated_at' => '2024-04-13 00:54:27',
            ),
            109 => 
            array (
                'id' => 115,
                'language_id' => 1,
                'word' => 'Close',
                'translation' => 'بستن',
                'created_at' => '2024-04-13 00:55:05',
                'updated_at' => '2024-04-13 00:55:05',
            ),
            110 => 
            array (
                'id' => 116,
                'language_id' => 1,
                'word' => 'Base units',
                'translation' => 'اصل واحد جنس',
                'created_at' => '2024-04-13 00:56:00',
                'updated_at' => '2024-04-13 00:56:00',
            ),
            111 => 
            array (
                'id' => 117,
                'language_id' => 1,
                'word' => 'Units conversions',
                'translation' => 'بادله واحد ها',
                'created_at' => '2024-04-13 00:56:20',
                'updated_at' => '2024-04-13 00:56:44',
            ),
            112 => 
            array (
                'id' => 118,
                'language_id' => 1,
                'word' => 'Add new base unit',
                'translation' => 'اضافه نمودن واحد اساسی جدید',
                'created_at' => '2024-04-13 00:57:20',
                'updated_at' => '2024-04-13 00:57:20',
            ),
            113 => 
            array (
                'id' => 119,
                'language_id' => 1,
                'word' => 'Unit conversions',
                'translation' => 'تبادله واحد ها',
                'created_at' => '2024-04-13 00:57:51',
                'updated_at' => '2024-04-13 00:58:14',
            ),
            114 => 
            array (
                'id' => 120,
                'language_id' => 1,
                'word' => 'Base unit',
                'translation' => 'واحد اساسی',
                'created_at' => '2024-04-13 00:58:30',
                'updated_at' => '2024-04-13 00:58:30',
            ),
            115 => 
            array (
                'id' => 121,
                'language_id' => 1,
                'word' => 'Amount',
                'translation' => 'مقدار',
                'created_at' => '2024-04-13 00:58:45',
                'updated_at' => '2024-04-13 00:58:45',
            ),
            116 => 
            array (
                'id' => 122,
                'language_id' => 1,
                'word' => 'Enter product name or code',
                'translation' => 'اسم جنس و یا کود نمبر را وارد نمایی',
                'created_at' => '2024-04-13 00:59:44',
                'updated_at' => '2024-04-13 01:00:18',
            ),
            117 => 
            array (
                'id' => 123,
                'language_id' => 1,
                'word' => 'No record found',
                'translation' => 'هیج دیتای دریافت نشد',
                'created_at' => '2024-04-13 01:01:10',
                'updated_at' => '2024-04-13 01:01:10',
            ),
            118 => 
            array (
                'id' => 124,
                'language_id' => 1,
                'word' => 'Page size',
                'translation' => 'اندازه صفحه',
                'created_at' => '2024-04-13 01:01:24',
                'updated_at' => '2024-04-13 01:01:24',
            ),
            119 => 
            array (
                'id' => 125,
                'language_id' => 1,
                'word' => 'Show company name',
                'translation' => 'نمایش اسم کامپنی',
                'created_at' => '2024-04-13 01:01:44',
                'updated_at' => '2024-04-13 01:01:44',
            ),
            120 => 
            array (
                'id' => 126,
                'language_id' => 1,
                'word' => 'Show product name',
                'translation' => 'نمایش اسم جنس',
                'created_at' => '2024-04-13 01:02:00',
                'updated_at' => '2024-04-13 01:02:00',
            ),
            121 => 
            array (
                'id' => 127,
                'language_id' => 1,
                'word' => 'Show product price',
                'translation' => 'نمایش قیمت جنس',
                'created_at' => '2024-04-13 01:02:13',
                'updated_at' => '2024-04-13 01:02:13',
            ),
            122 => 
            array (
                'id' => 128,
                'language_id' => 1,
                'word' => 'Preview',
                'translation' => 'مشاهده',
                'created_at' => '2024-04-13 01:02:21',
                'updated_at' => '2024-04-13 01:02:21',
            ),
            123 => 
            array (
                'id' => 129,
                'language_id' => 1,
                'word' => 'Reset',
                'translation' => 'از سر گیری',
                'created_at' => '2024-04-13 01:03:22',
                'updated_at' => '2024-04-13 01:03:22',
            ),
            124 => 
            array (
                'id' => 130,
                'language_id' => 1,
                'word' => 'Barcode',
                'translation' => 'بارکود',
                'created_at' => '2024-04-13 01:03:43',
                'updated_at' => '2024-04-13 01:03:43',
            ),
            125 => 
            array (
                'id' => 131,
                'language_id' => 1,
                'word' => 'Product unit conversion',
                'translation' => 'تبادله واحد جنس',
                'created_at' => '2024-04-13 01:04:11',
                'updated_at' => '2024-04-13 01:04:26',
            ),
            126 => 
            array (
                'id' => 132,
                'language_id' => 1,
                'word' => 'Products details',
                'translation' => 'معلومات جنس',
                'created_at' => '2024-04-13 01:05:11',
                'updated_at' => '2024-04-13 01:05:11',
            ),
            127 => 
            array (
                'id' => 133,
                'language_id' => 1,
                'word' => 'Products page',
                'translation' => 'صفحه اجناس',
                'created_at' => '2024-04-13 01:05:38',
                'updated_at' => '2024-04-13 01:05:38',
            ),
            128 => 
            array (
                'id' => 134,
                'language_id' => 1,
                'word' => 'Create adjustments',
                'translation' => 'تنظیم اجناس',
                'created_at' => '2024-04-13 01:07:24',
                'updated_at' => '2024-04-13 01:07:24',
            ),
            129 => 
            array (
                'id' => 135,
                'language_id' => 1,
                'word' => 'Product items',
                'translation' => 'جنس های گنجانده شده',
                'created_at' => '2024-04-13 01:07:53',
                'updated_at' => '2024-04-13 01:07:53',
            ),
            130 => 
            array (
                'id' => 136,
                'language_id' => 1,
                'word' => 'Adjustement unit',
                'translation' => 'واحد تنظیم جنس',
                'created_at' => '2024-04-13 01:08:18',
                'updated_at' => '2024-04-13 01:08:54',
            ),
            131 => 
            array (
                'id' => 137,
                'language_id' => 1,
                'word' => 'Stock',
                'translation' => 'گدام',
                'created_at' => '2024-04-13 01:08:24',
                'updated_at' => '2024-04-13 01:08:24',
            ),
            132 => 
            array (
                'id' => 138,
                'language_id' => 1,
                'word' => 'Type',
                'translation' => 'نویعت',
                'created_at' => '2024-04-13 01:08:35',
                'updated_at' => '2024-04-13 01:08:35',
            ),
            133 => 
            array (
                'id' => 139,
                'language_id' => 1,
                'word' => 'Action',
                'translation' => 'عملیات',
                'created_at' => '2024-04-13 01:09:14',
                'updated_at' => '2024-04-13 01:09:14',
            ),
            134 => 
            array (
                'id' => 140,
                'language_id' => 1,
                'word' => 'Cancel',
                'translation' => 'لغو',
                'created_at' => '2024-04-13 01:09:24',
                'updated_at' => '2024-04-13 01:09:24',
            ),
            135 => 
            array (
                'id' => 141,
                'language_id' => 1,
                'word' => 'No product selected',
                'translation' => 'هیج جنس انتخاب نشده',
                'created_at' => '2024-04-13 01:09:43',
                'updated_at' => '2024-04-13 01:09:43',
            ),
            136 => 
            array (
                'id' => 142,
                'language_id' => 1,
                'word' => 'Addition',
                'translation' => 'اضافه کردن',
                'created_at' => '2024-04-13 01:10:05',
                'updated_at' => '2024-04-13 01:10:05',
            ),
            137 => 
            array (
                'id' => 143,
                'language_id' => 1,
                'word' => 'Subtraction',
                'translation' => 'کم کردن',
                'created_at' => '2024-04-13 01:10:20',
                'updated_at' => '2024-04-13 01:10:20',
            ),
            138 => 
            array (
                'id' => 144,
                'language_id' => 1,
                'word' => 'Adjustment completed successfully',
                'translation' => 'تنظیمات موفقانه انجام شد',
                'created_at' => '2024-04-13 01:10:48',
                'updated_at' => '2024-04-13 01:10:48',
            ),
            139 => 
            array (
                'id' => 145,
                'language_id' => 1,
                'word' => 'Created on',
                'translation' => 'تاریخ اجراآت',
                'created_at' => '2024-04-13 01:11:11',
                'updated_at' => '2024-04-13 01:11:11',
            ),
            140 => 
            array (
                'id' => 146,
                'language_id' => 1,
                'word' => 'Adjustments Details',
                'translation' => 'معلومات تظیمات اجناس',
                'created_at' => '2024-04-13 01:11:37',
                'updated_at' => '2024-04-13 01:11:37',
            ),
            141 => 
            array (
                'id' => 147,
                'language_id' => 1,
                'word' => 'Meta data',
                'translation' => 'معلومات کلی',
                'created_at' => '2024-04-13 01:11:47',
                'updated_at' => '2024-04-13 01:11:47',
            ),
            142 => 
            array (
                'id' => 148,
                'language_id' => 1,
                'word' => 'List of products',
                'translation' => 'لیست اجناس',
                'created_at' => '2024-04-13 01:12:02',
                'updated_at' => '2024-04-13 01:12:02',
            ),
            143 => 
            array (
                'id' => 149,
                'language_id' => 1,
                'word' => 'Adjustment unit',
                'translation' => 'واحد تنظیمات',
                'created_at' => '2024-04-13 01:12:29',
                'updated_at' => '2024-04-13 01:12:29',
            ),
            144 => 
            array (
                'id' => 150,
                'language_id' => 1,
                'word' => 'List of all purchases',
                'translation' => 'لیست تمام خرید ها',
                'created_at' => '2024-04-13 01:14:24',
                'updated_at' => '2024-04-13 01:14:24',
            ),
            145 => 
            array (
                'id' => 151,
                'language_id' => 1,
                'word' => 'Application configurations',
                'translation' => 'تنظیمات سیستم',
                'created_at' => '2024-04-18 16:13:31',
                'updated_at' => '2024-04-18 16:13:31',
            ),
        ));
        
        
    }
}