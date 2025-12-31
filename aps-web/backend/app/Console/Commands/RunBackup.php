<?php

namespace App\Console\Commands;

use App\Events\TestEvent;
use App\Http\Controllers\Configurations\BackupController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will backup a file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backup = new BackupController();
        $backup->run();
    }
}
