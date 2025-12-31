<?php

namespace App\Console\Commands;

use App\Events\NotificationPushedEvent;
use App\Models\Notification;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckupProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checkup-product-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check the product expiration date and other things';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oneMonthFromNow = Carbon::now()->addMonth();
        $expiredProducts = Product::query()->whereDate('expiry_date', '<', now())->get();
        $nearToExpire = Product::query()->whereDate('expiry_date', '<=', $oneMonthFromNow)->whereDate('expiry_date', '>=', now())->get();
        foreach ($expiredProducts as $expiredProduct){
            if(
                !Notification::query()
                    ->where('model', 'product-expiration')
                    ->where('subject_id', $expiredProduct->id)->exists()
            ){
                event(new NotificationPushedEvent(
                    'product-expiration',
                    $expiredProduct->name.' ('.$expiredProduct->code.') product has expired',
                    'for-all',
                    $expiredProduct->id
                ));
            }
        }
        foreach ($nearToExpire as $nearToExpireProduct){
            if(
                !Notification::query()
                    ->where('model', 'near-to-expire')
                    ->where('subject_id', $nearToExpireProduct->id)->exists()
            ){
                event(new NotificationPushedEvent(
                    'near-to-expire',
                    $nearToExpireProduct->name.' ('.$nearToExpireProduct->code.') product  will be expired '.Carbon::make($nearToExpireProduct->expiry_date)->diffForHumans(),
                    'for-all',
                    $nearToExpireProduct->id
                ));
            }
        }
        $this->info('Succeed');
        return Command::SUCCESS;
    }
}
