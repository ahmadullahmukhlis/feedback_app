<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckProductionMode extends Command
{
    protected $signature = 'custom:check-production-mode';

    protected $description = 'Check if application is in production mode and execute php artisan down if conditions are met.';

    public function handle()
    {
        $environment = app()->environment();

        if ($environment === 'production') {
            $lastDownTime = config('app.last_down_time');
            $currentTime = Carbon::now();

            if ($currentTime->diffInMonths($lastDownTime) >= 12) {
                $this->call('down');
                config(['app.last_down_time' => $currentTime]);
            }
        } elseif ($environment === 'local') {
            $lastDownTime = config('app.last_down_time');
            $currentTime = Carbon::now();

            if ($currentTime->diffInMonths($lastDownTime) >= 1) {
                $this->call('down');
                config(['app.last_down_time' => $currentTime]);
            }
        }
    }
}
