<?php

namespace App\Listeners;

use App\Account;
use App\Events\ViewAccountEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;

class ViewAccountEventListener
{
    /**
     * Create the event listener.
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     *  Összes megnézett account id
     *
     * @return Array
     */
    private function getViewedAccounts()
    {
        return $this->session->get('viewed_accounts', null);
    }

    /**
     * Átmegy a session viewed.accounts array-en és visszaad
     * egy olyan array-t amiben nincsenek benne a lejárt view-k
     *
     * @param array $accounts
     * @param int $throttleTime
     * @return array
     */
    private function cleanExpiredViews($accounts, $throttleTime=3600)
    {
        $time = time();

        // Filter through the post array. The argument passed to the
        // function will be the value from the array, which is the
        // timestamp in our case.
        return array_filter($accounts, function ($timestamp) use ($time, $throttleTime)
        {
            // If the view timestamp + the throttle time is
            // still after the current timestamp the view
            // has not expired yet, so we want to keep it.
            return ($timestamp + $throttleTime) > $time;
        });
    }

    /**
     * A filterezett viewed arrayel felülírja az előzőt
     *
     * @param $accounts
     */
    private function storeAccounts($accounts)
    {
        $this->session->put('viewed_accounts', $accounts);
    }

    /**
     * @param \App\Account $account
     * @return bool
     */
    private function isAccountViewed($account)
    {

        $viewed = $this->session->get('viewed_accounts', []);

        return array_key_exists($account->id, $viewed);
    }

    private function storeAccount($account)
    {
        $key = 'viewed_accounts.' . $account->id;
        $this->session->put($key, time());
    }

    /**
     * Handle the event.
     * Lejárt nézettségblokkolások feloldása
     * Nézettség növelése,ha 0.5 óra eltelt az előző
     * nézés óta
     *
     * @param  ViewAccountEvent  $event
     * @return void
     */
    public function handle(ViewAccountEvent $event)
    {
        $accounts = $this->getViewedAccounts();

        if ( ! is_null($accounts)) {
            $this->storeAccounts($this->cleanExpiredViews($accounts , 1800));
        }

        if ( ! $this->isAccountViewed($event->account)) {
            $event->account->increment('view_count');
            $this->storeAccount($event->account);
        }
    }


}
