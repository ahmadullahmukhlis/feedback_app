<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoginLogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('login_logs')->delete();
        
        \DB::table('login_logs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '1|WVfegMnHhLw7YAOD9IWBMX18ffshMx8ygKeNP7Qg0edcda9e',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:39:40',
                'updated_at' => '2025-12-30 10:39:40',
            ),
            1 => 
            array (
                'id' => 2,
                'email' => 'ahmadullahmukhlis2025@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '2|TS8hmZ6aoWJfbdAGf8NajbZGJ2FV5bYPGANUxIDe39e2b977',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:42:16',
                'updated_at' => '2025-12-30 10:42:16',
            ),
            2 => 
            array (
                'id' => 3,
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '3|9na1wCLuUeYWQhcQ9bSFdErrMrCIlbd5LSL1qo02e14902ad',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:50:15',
                'updated_at' => '2025-12-30 10:50:15',
            ),
            3 => 
            array (
                'id' => 4,
                'email' => 'ahmadullahmukhlis2025@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '4|9btpHUqBboKDEFkKFFn2lYjIO2iYixvP9dEFO7FX68f03d68',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:51:51',
                'updated_at' => '2025-12-30 10:51:51',
            ),
            4 => 
            array (
                'id' => 5,
                'email' => 'admin@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-12-30 10:55:00',
                'updated_at' => '2025-12-30 10:55:00',
            ),
            5 => 
            array (
                'id' => 6,
                'email' => 'ahmadullahmukhlis2025@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '5|vMHjYi78z68HFsihfP5cDONqTSspTAPwQSk0KJmy8c0e7781',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:55:10',
                'updated_at' => '2025-12-30 10:55:10',
            ),
            6 => 
            array (
                'id' => 7,
                'email' => 'admin@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '6|aLRV6QANmzUHJmirvLgSo97X0lTqtPZc4od1Y0iK2f48c66f',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:57:45',
                'updated_at' => '2025-12-30 10:57:45',
            ),
            7 => 
            array (
                'id' => 8,
                'email' => 'ahmadullahmukhlis2025@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '7|rjltvUWSaqmn9p5980NS1xEmSJ6hlLFGZ91BgitVa9f3c830',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:58:34',
                'updated_at' => '2025-12-30 10:58:34',
            ),
            8 => 
            array (
                'id' => 9,
                'email' => 'admin@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '8|PYR5egLwuRFaHRO3olHkDPWj1YOGSSYE1WnM1S8Zf659406f',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 10:59:20',
                'updated_at' => '2025-12-30 10:59:20',
            ),
            9 => 
            array (
                'id' => 10,
                'email' => 'ahmadullahmukhlis2025@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '9|0rFVG1nk1E99dHHGqg2RiHCYmcpjthha8k9YgAVCb8b54827',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 11:00:02',
                'updated_at' => '2025-12-30 11:00:02',
            ),
            10 => 
            array (
                'id' => 11,
                'email' => 'admin@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '10|ocRaEUo9NgqKwOm1LBrhBeiQ0ECLVdA9BnuKkAxwaaddf3c6',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-12-30 11:01:21',
                'updated_at' => '2025-12-30 11:01:21',
            ),
        ));
        
        
    }
}