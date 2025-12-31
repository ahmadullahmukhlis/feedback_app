<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResponseEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $response;
    private $userId;

    public function __construct(array $response, $userId)
    {
        $this->response = $response;
        $this->userId = $userId;
    }

    public function broadcastOn(): array
    {
        // Public channel, no auth needed
        return [
            new Channel('response-' . $this->userId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ResponseEvent';
    }
}
