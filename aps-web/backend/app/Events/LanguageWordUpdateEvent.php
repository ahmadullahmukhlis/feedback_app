<?php

namespace App\Events;

use App\Jobs\UpdateLocalizationTables;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LanguageWordUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
    }
    public function broadcastOn(): array
    {
        UpdateLocalizationTables::dispatch();
        return [
            new PrivateChannel('applicationChannel'),
        ];
    }
}
