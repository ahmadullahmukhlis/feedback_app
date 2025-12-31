<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Access',
                'key' => 'user-management-access',
                'permission_group_id' => 1,
                'created_at' => '2024-11-16 03:05:31',
                'updated_at' => '2024-11-16 03:05:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Access',
                'key' => 'users-access',
                'permission_group_id' => 2,
                'created_at' => '2024-11-17 16:00:21',
                'updated_at' => '2024-11-17 16:00:21',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Access',
                'key' => 'log-activity-access',
                'permission_group_id' => 6,
                'created_at' => '2024-11-17 16:00:39',
                'updated_at' => '2024-11-17 16:00:39',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'View details',
                'key' => 'log-activity-view-details',
                'permission_group_id' => 6,
                'created_at' => '2024-11-17 16:00:46',
                'updated_at' => '2024-11-17 16:00:46',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Recover delete record',
                'key' => 'log-activity-recover-delete-record',
                'permission_group_id' => 6,
                'created_at' => '2024-11-17 16:00:57',
                'updated_at' => '2024-11-17 16:00:57',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Access',
                'key' => 'roles-access',
                'permission_group_id' => 3,
                'created_at' => '2024-11-17 16:01:28',
                'updated_at' => '2024-11-17 16:01:28',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Create',
                'key' => 'roles-create',
                'permission_group_id' => 3,
                'created_at' => '2024-11-17 16:01:30',
                'updated_at' => '2024-11-17 16:01:30',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Edit',
                'key' => 'roles-edit',
                'permission_group_id' => 3,
                'created_at' => '2024-11-17 16:01:32',
                'updated_at' => '2024-11-17 16:01:32',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Delete',
                'key' => 'roles-delete',
                'permission_group_id' => 3,
                'created_at' => '2024-11-17 16:01:35',
                'updated_at' => '2024-11-17 16:01:35',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'View details',
                'key' => 'roles-view-details',
                'permission_group_id' => 3,
                'created_at' => '2024-11-17 16:01:38',
                'updated_at' => '2024-11-17 16:01:38',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Access',
                'key' => 'activity-log-access',
                'permission_group_id' => 4,
                'created_at' => '2024-11-17 16:02:10',
                'updated_at' => '2024-11-17 16:02:10',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'View details',
                'key' => 'activity-log-view-details',
                'permission_group_id' => 4,
                'created_at' => '2024-11-17 16:02:16',
                'updated_at' => '2024-11-17 16:02:16',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Recover delete record',
                'key' => 'activity-log-recover-delete-record',
                'permission_group_id' => 4,
                'created_at' => '2024-11-17 16:02:29',
                'updated_at' => '2024-11-17 16:02:29',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Access',
                'key' => 'login-log-access',
                'permission_group_id' => 5,
                'created_at' => '2024-11-17 16:02:45',
                'updated_at' => '2024-11-17 16:02:45',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Access',
                'key' => 'configurations-access',
                'permission_group_id' => 7,
                'created_at' => '2024-11-17 16:03:25',
                'updated_at' => '2024-11-17 16:03:25',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Access',
                'key' => 'backup-access',
                'permission_group_id' => 8,
                'created_at' => '2024-11-17 16:03:55',
                'updated_at' => '2024-11-17 16:03:55',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Run backup',
                'key' => 'backup-run-backup',
                'permission_group_id' => 8,
                'created_at' => '2024-11-17 16:04:04',
                'updated_at' => '2024-11-17 16:04:04',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Download backup',
                'key' => 'backup-download-backup',
                'permission_group_id' => 8,
                'created_at' => '2024-11-17 16:04:10',
                'updated_at' => '2024-11-17 16:04:10',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Restore backup',
                'key' => 'backup-restore-backup',
                'permission_group_id' => 8,
                'created_at' => '2024-11-17 16:04:15',
                'updated_at' => '2024-11-17 16:04:15',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Change backup',
                'key' => 'backup-change-backup',
                'permission_group_id' => 8,
                'created_at' => '2024-11-17 16:04:19',
                'updated_at' => '2024-11-17 16:04:19',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Access',
                'key' => 'languages-access',
                'permission_group_id' => 9,
                'created_at' => '2024-11-17 16:04:46',
                'updated_at' => '2024-11-17 16:04:46',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Create',
                'key' => 'languages-create',
                'permission_group_id' => 9,
                'created_at' => '2024-11-17 16:04:49',
                'updated_at' => '2024-11-17 16:04:49',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'View details',
                'key' => 'languages-view-details',
                'permission_group_id' => 9,
                'created_at' => '2024-11-17 16:04:56',
                'updated_at' => '2024-11-17 16:04:56',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Delete',
                'key' => 'languages-delete',
                'permission_group_id' => 9,
                'created_at' => '2024-11-17 16:05:00',
                'updated_at' => '2024-11-17 16:05:00',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Access',
                'key' => 'language-dictionary-access',
                'permission_group_id' => 10,
                'created_at' => '2024-11-17 16:06:15',
                'updated_at' => '2024-11-17 16:06:15',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Add word',
                'key' => 'language-dictionary-add-word',
                'permission_group_id' => 10,
                'created_at' => '2024-11-17 16:06:21',
                'updated_at' => '2024-11-17 16:06:21',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Edit word',
                'key' => 'language-dictionary-edit-word',
                'permission_group_id' => 10,
                'created_at' => '2024-11-17 16:06:25',
                'updated_at' => '2024-11-17 16:06:25',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Delete word',
                'key' => 'language-dictionary-delete-word',
                'permission_group_id' => 10,
                'created_at' => '2024-11-17 16:06:28',
                'updated_at' => '2024-11-17 16:06:28',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'messages-access',
                'key' => 'messaging-system-messages-access',
                'permission_group_id' => 11,
                'created_at' => '2025-12-30 10:42:57',
                'updated_at' => '2025-12-30 10:42:57',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'view-messages',
                'key' => 'messaging-system-view-messages',
                'permission_group_id' => 11,
                'created_at' => '2025-12-30 10:45:33',
                'updated_at' => '2025-12-30 10:45:33',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'message-response',
                'key' => 'messaging-system-message-response',
                'permission_group_id' => 11,
                'created_at' => '2025-12-30 10:46:26',
                'updated_at' => '2025-12-30 10:46:26',
            ),
        ));
        
        
    }
}