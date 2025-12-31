<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permission_groups')->delete();
        
        \DB::table('permission_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'User management',
                'icon' => 'people',
                'permission_group_id' => 0,
                'sort' => 0,
                'created_at' => '2024-11-16 03:05:25',
                'updated_at' => '2024-11-16 03:05:25',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Users',
                'icon' => 'person',
                'permission_group_id' => 1,
                'sort' => 0,
                'created_at' => '2024-11-17 15:59:25',
                'updated_at' => '2024-11-17 15:59:25',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Roles',
                'icon' => 'lock',
                'permission_group_id' => 1,
                'sort' => 1,
                'created_at' => '2024-11-17 15:59:33',
                'updated_at' => '2024-11-17 15:59:43',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Activity log',
                'icon' => 'directions_run',
                'permission_group_id' => 1,
                'sort' => 2,
                'created_at' => '2024-11-17 15:59:58',
                'updated_at' => '2024-11-17 15:59:58',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Login log',
                'icon' => 'article',
                'permission_group_id' => 1,
                'sort' => 3,
                'created_at' => '2024-11-17 16:00:12',
                'updated_at' => '2024-11-17 16:00:12',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Log activity',
                'icon' => NULL,
                'permission_group_id' => 2,
                'sort' => 0,
                'created_at' => '2024-11-17 16:00:32',
                'updated_at' => '2024-11-17 16:00:32',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Configurations',
                'icon' => 'settings',
                'permission_group_id' => 0,
                'sort' => 1,
                'created_at' => '2024-11-17 16:03:16',
                'updated_at' => '2024-11-17 16:03:16',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Backup',
                'icon' => 'cloud_download',
                'permission_group_id' => 7,
                'sort' => 0,
                'created_at' => '2024-11-17 16:03:49',
                'updated_at' => '2024-11-17 16:03:49',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Languages',
                'icon' => 'language',
                'permission_group_id' => 7,
                'sort' => 1,
                'created_at' => '2024-11-17 16:04:35',
                'updated_at' => '2024-11-17 16:04:40',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Language dictionary',
                'icon' => 'g_translate',
                'permission_group_id' => 9,
                'sort' => 0,
                'created_at' => '2024-11-17 16:06:02',
                'updated_at' => '2024-11-17 16:06:10',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'messaging-system',
                'icon' => 'message',
                'permission_group_id' => 0,
                'sort' => 2,
                'created_at' => '2025-12-30 10:42:44',
                'updated_at' => '2025-12-30 10:42:44',
            ),
        ));
        
        
    }
}