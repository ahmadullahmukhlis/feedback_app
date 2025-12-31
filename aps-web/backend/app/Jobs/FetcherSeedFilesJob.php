<?php

namespace App\Jobs;

use App\Events\NotifyEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class   FetcherSeedFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct()
    {
        //
    }
    public function handle(): void
    {
        Artisan::call('migrate-fresh --only-seed');
        event(new NotifyEvent("Seeding files updated"));
    }
}
