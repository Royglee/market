<?php

namespace App\Listeners;

use App\Events\ViewPostEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewPostEventListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ViewPostEvent  $event
     * @return void
     */
    public function handle(ViewPostEvent $event)
    {
        $event->account->increment('view_count');
        //$event->account['view_count'] += 1;
    }
}
