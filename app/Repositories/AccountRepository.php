<?php
namespace App\Repositories;


use App\Account;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;

class AccountRepository {

    protected $account;

    function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function getAccountsWithUsers(Array $user_colums=[], $orderBy="created_at")
    {
        return $this->account->withUser($user_colums)->orderBy($orderBy, 'desc')->get();

    }
    public function getFilteredAccountsWithUsers( Array $input, Array $user_colums=[])
    {
        $accounts= $this->account->withUser($user_colums);

        if (isset($input['league'])) {
            $accounts= $accounts->whereIn('league', $input['league']);
        }

        if (isset($input['server'])) {
            $accounts= $accounts->whereIn('server', $input['server']);
        }

        if (isset($input['order'])) {
            switch ($input['order']) {
                case 'created_at':
                    $accounts=  $accounts->orderBy('created_at', 'desc');
                    break;
                case 'view_count':
                    $accounts=  $accounts->orderBy('view_count', 'desc');
                    break;
                case 'league':
                    $accounts=  $accounts->orderByRaw('FIELD(league, "' . implode('", "', $this->leagues()) . '") DESC, division ASC');
                    break;
                case 'league_asc':
                    $accounts=  $accounts->orderByRaw('FIELD(league, "' . implode('", "', $this->leagues()) . '") ASC, division DESC');
                    break;
                case 'champions':
                    $accounts=  $accounts->orderBy('champions', 'desc');
                    break;
                case 'skins':
                    $accounts=  $accounts->orderBy('skins', 'desc');
                    break;
                case 'price':
                    $accounts=  $accounts->orderBy('price', 'desc');
                    break;
                case 'price_asc':
                    $accounts=  $accounts->orderBy('price', 'asc');
                    break;
            }
        }
        else{
            $accounts=  $accounts->orderBy('created_at', 'desc');
        }

        if (isset($input['champion']) && $input['champion'] > 0 ) {
            $accounts= $accounts->where('champions','>' ,$input['champion']);
        }

        if (isset($input['skin']) && $input['skin'] > 0) {
            $accounts= $accounts->where('skins','>' ,$input['skin']);
        }

        return $accounts->get();

    }

    public function servers()
    {
        return ['NA', 'EUNE', 'EUW', 'OCE', 'BR', 'LA', 'RU', 'TR', 'KR'];
    }

    public function leagues()
    {
        return ['Unranked','Bronze','Silver','Gold','Platinum','Diamond','Master','Challenger'];
    }

    public function sold()
    {   $faker = Faker::create();
        $order = new Order();
        if ($this->account->count > 1)
        {
            $this->account->count-= 1;
        }
        else {
            $this->account->sold = 1;
        }
        $this->account->save();

        $order -> account_id = $this->account->id;
        $order -> user_id = Auth::id();
        $order->payKey = $faker ->lexify('??????????????????');
        $order->save();

        dd($order->all()->toArray());


        return $this->account;
    }
}