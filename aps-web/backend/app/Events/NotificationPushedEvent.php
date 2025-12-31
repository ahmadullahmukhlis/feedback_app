<?php

namespace App\Events;

use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use mysql_xdevapi\Collection;

class NotificationPushedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct($model, $message, $permissions, $subject_id){
        Notification::query()->create([
            'model' => $model,
            'message' => $message,
            'permissions' => $permissions,
            'subject_id' => $subject_id,
        ]);
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('applicationChannel'),
        ];
    }
}
