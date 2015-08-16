<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TradeStatusChangedEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    private $userid;

    /**
     * Create a new event instance.
     * @param array $userid
     */
    public function __construct($userid)
    {
        $this->userid = $userid;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return $this->userid;
    }
}
