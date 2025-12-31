<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-11-16 03:03:15',
                'updated_at' => '2024-11-16 03:03:15',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'message',
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => '2025-12-30 10:41:23',
                'updated_at' => '2025-12-30 10:41:23',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'manager',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2025-12-30 10:55:57',
                'updated_at' => '2025-12-30 10:55:57',
            ),
        ));
        
        
    }
}