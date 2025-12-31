<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccountingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $warehouse_id;
    public $currency_id;
    public $account_type;
    public $product_id;
    public $service;
    public $amount;
    public $particular;
    public $module;
    public $customer_id;

    public function __construct($service, $warehouse_id = 0, $currency_id = 0, $account_type = 0, $product_id = 0, $amount=0, $particular = 0, $module = null, $customer_id = 0)
    {
        $this->warehouse_id = $warehouse_id;
        $this->currency_id = $currency_id;
        $this->account_type = $account_type;
        $this->product_id = $product_id;
        $this->service = $service;
        $this->amount = $amount;
        $this->particular = $particular;
        $this->module = $module;
        $this->customer_id = $customer_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
