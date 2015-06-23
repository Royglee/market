<?php namespace App\Http\Controllers;

use App\Account;
use App\Events\ViewAccountEvent;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Repositories\AccountRepository;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Event;
use Illuminate\Support\Facades\Input;


class AccountsController extends Controller {
    function __construct()
    {
        $this->middleware('auth',['only' => 'create']);
        $this->middleware('account.owner',['only' => ['edit','update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Account|AccountRepository $accounts
     * @param Request $request
     * @return Response
     * @internal param Account $var
     * @internal param Account $accounts
     */
	public function index(AccountRepository $accounts,  Request $request)
	{
        $input = $request->all();
        $servers = $accounts->servers();
        $leagues = $accounts->leagues();
        $accounts = $accounts->getFilteredAccountsWithUsers($input, ['name']);
        return view('accounts.index', compact('accounts','input','servers','leagues'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('accounts.create_v2');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAccountRequest|Request $request
     * @return Response
     * @internal param Request $data
     */
	public function store(CreateAccountRequest $request)
	{
        $request->user()->accounts()->create($request->all());

        return redirect()->action('AccountsController@index');
	}

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return Response
     * @internal param $id
     * @internal param $account
     * @internal param int $id
     */
	public function show(Account $account)
	{
        Event::fire(new ViewAccountEvent($account));
        return view('accounts.show', compact('account'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param Account $account
     * @return Response
     * @internal param int $id
     */
	public function edit(Account $account)
	{
        $account = $account->toArray();
        return view('accounts.edit', compact('account'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param Account $account
     * @param CreateAccountRequest $request
     * @return Response
     * @internal param int $id
     */
	public function update(Account $account, CreateAccountRequest $request)
	{
        $account->fill($request->all())->save();

        return redirect()->action('AccountsController@index');
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param Account $account
     * @return Response
     * @internal param int $id
     */
	public function destroy(Account $account)
	{
		$account->delete();
        return back();
	}

}
