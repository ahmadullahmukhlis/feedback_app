<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolePermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_permissions')->delete();
        
        \DB::table('role_permissions')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'permission_id' => 1,
            ),
            1 => 
            array (
                'role_id' => 1,
                'permission_id' => 2,
            ),
            2 => 
            array (
                'role_id' => 1,
                'permission_id' => 3,
            ),
            3 => 
            array (
                'role_id' => 1,
                'permission_id' => 4,
            ),
            4 => 
            array (
                'role_id' => 1,
                'permission_id' => 5,
            ),
            5 => 
            array (
                'role_id' => 1,
                'permission_id' => 6,
            ),
            6 => 
            array (
                'role_id' => 1,
                'permission_id' => 7,
            ),
            7 => 
            array (
                'role_id' => 1,
                'permission_id' => 8,
            ),
            8 => 
            array (
                'role_id' => 1,
                'permission_id' => 9,
            ),
            9 => 
            array (
                'role_id' => 1,
                'permission_id' => 10,
            ),
            10 => 
            array (
                'role_id' => 1,
                'permission_id' => 14,
            ),
            11 => 
            array (
                'role_id' => 1,
                'permission_id' => 11,
            ),
            12 => 
            array (
                'role_id' => 1,
                'permission_id' => 12,
            ),
            13 => 
            array (
                'role_id' => 1,
                'permission_id' => 13,
            ),
            14 => 
            array (
                'role_id' => 1,
                'permission_id' => 15,
            ),
            15 => 
            array (
                'role_id' => 1,
                'permission_id' => 21,
            ),
            16 => 
            array (
                'role_id' => 1,
                'permission_id' => 22,
            ),
            17 => 
            array (
                'role_id' => 1,
                'permission_id' => 16,
            ),
            18 => 
            array (
                'role_id' => 1,
                'permission_id' => 20,
            ),
            19 => 
            array (
                'role_id' => 1,
                'permission_id' => 17,
            ),
            20 => 
            array (
                'role_id' => 1,
                'permission_id' => 18,
            ),
            21 => 
            array (
                'role_id' => 1,
                'permission_id' => 19,
            ),
            22 => 
            array (
                'role_id' => 1,
                'permission_id' => 23,
            ),
            23 => 
            array (
                'role_id' => 1,
                'permission_id' => 24,
            ),
            24 => 
            array (
                'role_id' => 1,
                'permission_id' => 25,
            ),
            25 => 
            array (
                'role_id' => 1,
                'permission_id' => 26,
            ),
            26 => 
            array (
                'role_id' => 1,
                'permission_id' => 27,
            ),
            27 => 
            array (
                'role_id' => 1,
                'permission_id' => 28,
            ),
            28 => 
            array (
                'role_id' => 2,
                'permission_id' => 29,
            ),
            29 => 
            array (
                'role_id' => 2,
                'permission_id' => 30,
            ),
            30 => 
            array (
                'role_id' => 2,
                'permission_id' => 31,
            ),
            31 => 
            array (
                'role_id' => 3,
                'permission_id' => 3,
            ),
            32 => 
            array (
                'role_id' => 3,
                'permission_id' => 4,
            ),
            33 => 
            array (
                'role_id' => 3,
                'permission_id' => 5,
            ),
            34 => 
            array (
                'role_id' => 3,
                'permission_id' => 29,
            ),
            35 => 
            array (
                'role_id' => 3,
                'permission_id' => 30,
            ),
            36 => 
            array (
                'role_id' => 3,
                'permission_id' => 31,
            ),
        ));
        
        
    }
}