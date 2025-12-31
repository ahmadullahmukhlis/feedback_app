<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class WebSocketHandler implements MessageComponentInterface
{

    public function onOpen(ConnectionInterface $connection)
    {
        Log::info('A connection has been established');
        // TODO: Implement onOpen() method.
    }

    public function onClose(ConnectionInterface $connection)
    {
        Log::info('A connection has been closed');
        // TODO: Implement onClose() method.
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        Log::info('Connection error: ' . $e);
        // TODO: Implement onError() method.
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $msg)
    {
        Log::info('Message received: ' . $msg);
        // TODO: Implement onMessage() method.
    }
}
