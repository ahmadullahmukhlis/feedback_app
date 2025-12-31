<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PersonalAccessTokensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('personal_access_tokens')->delete();
        
        \DB::table('personal_access_tokens')->insert(array (
            0 => 
            array (
                'id' => 10,
                'tokenable_type' => 'App\\Models\\User',
                'tokenable_id' => 3,
                'name' => 'user_token',
                'token' => '60b0bcd8a34adf1e65153a5673d2433a5d99f6c4de7d75733959141b9e653c00',
                'abilities' => '["*"]',
                'last_used_at' => '2025-12-30 12:24:33',
                'expires_at' => NULL,
                'created_at' => '2025-12-30 11:01:21',
                'updated_at' => '2025-12-30 12:24:33',
            ),
        ));
        
        
    }
}