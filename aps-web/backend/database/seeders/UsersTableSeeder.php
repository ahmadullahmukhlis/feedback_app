<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'image' => NULL,
                'first_name' => 'Ahmadullah',
                'last_name' => 'Mukhlis',
                'email' => 'ahmadullahmukhlis2025@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$KRXoPSTT/AKNJfKSUjGXEOe2M4F6RUULzUkZ3fx/GBELND.kbLR3u',
                'is_active' => 1,
                'is_verified' => 1,
                'change_password' => 0,
                'remember_token' => NULL,
                'created_at' => '2023-09-11 18:51:48',
                'updated_at' => '2023-09-11 18:51:48',
                'google_id' => NULL,
                'google_token' => NULL,
                'is_user' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'image' => 'http://localhost:8000/storage/users-profile/PbsodESXpLiiNAyxpNi6fLuyptW5Ccp61o74obE3.png',
                'first_name' => 'Ahmadullah',
                'last_name' => 'Mukhlis',
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$KRXoPSTT/AKNJfKSUjGXEOe2M4F6RUULzUkZ3fx/GBELND.kbLR3u',
                'is_active' => 1,
                'is_verified' => 1,
                'change_password' => 0,
                'remember_token' => NULL,
                'created_at' => '2023-09-11 18:55:34',
                'updated_at' => '2024-04-17 01:19:44',
                'google_id' => NULL,
                'google_token' => NULL,
                'is_user' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'image' => 'http://localhost:8000/storage/users-profile/VvEfh4IA7rOkdBknbtfKaz0mcOkt48RxdNNwb5Tf.png',
                'first_name' => 'Admin',
                'last_name' => 'test',
                'email' => 'admin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$cd52MwJuUaY7gpL7JMOP5uGgSH0ptMHQL4tp5CyoCJQqsaQfcauZW',
                'is_active' => 1,
                'is_verified' => 1,
                'change_password' => 0,
                'remember_token' => NULL,
                'created_at' => '2025-12-30 10:54:25',
                'updated_at' => '2025-12-30 11:01:29',
                'google_id' => NULL,
                'google_token' => NULL,
                'is_user' => 1,
            ),
        ));
        
        
    }
}