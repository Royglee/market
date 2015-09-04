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
    public $orderId;

    /**
     * Create a new event instance.
     * @param array $userid
     * @param $orderId
     */
    public function __construct($userid, $orderId)
    {
        $this->userid = $userid;
        $this->orderId = $orderId;

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
