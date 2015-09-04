<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessageEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    private $users;
    public $message;
    public $sender;
    public $orderId;

    /**
     * Create a new event instance.
     *
     * @param $users
     * @param $sender
     * @param $message
     * @param $orderId
     */
    public function __construct($users, $sender, $message, $orderId)
    {
        $this->users = $users;
        $this->message = $message;
        $this->sender = $sender;
        $this->orderId = $orderId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return $this->users;
    }
}
