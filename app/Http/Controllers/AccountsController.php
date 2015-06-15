<?php namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class AccountsController extends Controller {
    function __construct()
    {
        $this->middleware('auth',['only' => 'create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Account $accounts
     * @return Response
     * @internal param Account $var
     * @internal param Account $accounts
     */
	public function index(Account $accounts)
	{
       /* $accounts = Cache::remember('account', 5, function() use ($accounts)
        {
            return $accounts->with('user')->get();
        });*/
        //Cache::forget('account');
        $accounts= $accounts->withUser(['name'])->orderBy('created_at', 'desc')->get();

        return view('accounts.index', compact('accounts'));
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
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
