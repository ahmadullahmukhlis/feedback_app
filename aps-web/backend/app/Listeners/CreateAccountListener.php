<?php

namespace App\Listeners;

use App\Models\AccountType;
use App\Models\Currency;
use App\Models\Warehouse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateAccountListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }



    public function handle(object $event): void
    {
        $warehouse_code = str_pad($event->warehouse_id, 3, '0',STR_PAD_RIGHT);

        if($event->warehouse_id === 0){
            $warehouse_ids = Warehouse::query()->select('id')->pluck('id')->toArray();
        }else{

        }
        if($event->currency_id === 0){
            $currency_ids = Currency::query()->select('id')->pluck('id')->toArray();
        }else{
            $currency_code = str_pad($event->currency_id, 3, '0',STR_PAD_RIGHT);
        }
        if($event->account_type === 0){
            $currency_ids = AccountType::query()->select('id')->pluck('id')->toArray();
        }else{
            $account_type_code = str_pad($event->account_type, 3, '0',STR_PAD_RIGHT);
        }
    }
}
