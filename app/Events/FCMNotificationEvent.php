<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FCMNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $body;
    public $title;
    public $image;
    public $recievers;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($body,$title,$image,$recievers)
    {
        $this->body=$body;
        $this->title=$title;
        $this->image=$image;
        $this->recievers=$recievers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new PrivateChannel('channel-name');
    }
}
