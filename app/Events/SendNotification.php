<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notificationData;

    public function __construct($notificationData)
    {
        $this->notificationData = $notificationData;
    }

    public function broadcastOn()
    {
        return new Channel('orders'); // Broadcasting on the 'orders' channel
    }

    // Set the broadcast event name
    public function broadcastAs()
    {
        return 'send.notification'; // This will be the event name the frontend listens to
    }

    // The data you want to broadcast
    public function broadcastWith()
    {
        return [
            'notification' => $this->notificationData, // Customize this to your data
        ];
    }
}
