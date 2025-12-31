<?php

namespace App\Console\Commands;

use App\Events\DoAccountEvent;
use App\Models\SoftwareSetting;
use Illuminate\Console\Command;

class DoAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:do-account-command {service}';

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
        event(new DoAccountEvent(
            $this->argument('service'),
            SoftwareSetting::query()->first()->warehouse_id,
            SoftwareSetting::query()->first()->currency_id,
            8
        ));
        $this->info($this->argument('service'));
        return Command::SUCCESS;
    }
}
