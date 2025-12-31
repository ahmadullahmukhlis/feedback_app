<?php

namespace App\Console\Commands;

use App\Events\AccountingEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-account-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        event(new AccountingEvent());
        $this->info('Succeeded');
        return Command::SUCCESS;
    }
}
