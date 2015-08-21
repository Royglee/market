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

    /**
     * Create a new event instance.
     *
     * @param $users
     * @param $sender
     * @param $message
     */
    public function __construct($users, $sender, $message)
    {
        $this->users = $users;
        $this->message = $message;
        $this->sender = $sender;
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
