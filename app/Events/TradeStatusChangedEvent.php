<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TradeStatusChangedEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $user;

    /**
     * Create a new event instance.
     *
     */
    public function __construct()
    {
        $this->user = User::find(1);
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['test-chanel'];
    }
}
