<?php

namespace App\Console\Commands;

use App\Events\NotifyEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class MigrateFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate-fresh {--only-seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh migrations with losing any data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // $tables = Schema::getAllTables();
        $tables = DB::select('SHOW TABLES');
        $app_table = "Tables_in_" . env('DB_DATABASE');
        $ignore_migration_tables = ['migrations', 'activity_log'];
        $seed_table = implode(',', collect($tables)->filter(function ($table) use ($app_table, $ignore_migration_tables) {
            return !in_array($table->$app_table, $ignore_migration_tables) && $table->$app_table;
        })->pluck($app_table)->toArray());
        $this->info('Seeding started');
        Artisan::call('iseed ' . $seed_table . ' --force');
        $this->info('Seeding finished successfully');
        // if (!$this->hasOption('only-seed')) {
        //     Artisan::call('migrate:fresh --seed');
        //     $this->info('Migration completed successfully');
        // }
        if (!$this->option('only-seed')) {
            Artisan::call('migrate:fresh --seed');
            $this->info('Migration completed successfully');
        }
        event(new NotifyEvent("Seeding finished successfully"));
        return Command::SUCCESS;
    }
}
