<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BackupHistoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('backup_histories')->delete();
        
        
        
    }
}