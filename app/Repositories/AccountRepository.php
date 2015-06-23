<?php
namespace App\Repositories;


use App\Account;
use Illuminate\Http\Request;

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
                    $accounts=  $accounts->orderByRaw('FIELD(league, "' . implode('", "', $this->leagues()) . '") DESC');
                    break;
            }
        }
        else{
            $accounts=  $accounts->orderBy('created_at', 'desc');
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

}