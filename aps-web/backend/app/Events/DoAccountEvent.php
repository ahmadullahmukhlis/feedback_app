<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DoAccountEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $service;
    public $warehouse_id;
    public $currency_id;
    public $product_id;

    public function __construct($service, $warehouse_id=0, $currency_id = 0, $product_id = 0)
    {
        $this->service = $service;
        $this->warehouse_id = $warehouse_id;
        $this->currency_id = $currency_id;
        $this->product_id = $product_id;
    }
}
