<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/config',function(){
    $paypal = new \App\Services\PaymentService();
    $paypal->sendPayment();
    $paykey = $paypal->setPaymentOptions();
    return view('paypal',compact('paykey'));
});
Route::get('/success', function(){
    return view('succes');
});
// End of test things


Route::get('/', 'AccountsController@index');
Route::get('home', 'HomeController@index');

get('accounts', 'AccountsController@index');
post('accounts', 'AccountsController@filter');

get('accounts/create','AccountsController@create');
post('accounts/store','AccountsController@store');

get('accounts/{account}/edit','AccountsController@edit');
patch('accounts/{account}','AccountsController@update');
delete('accounts/{account}','AccountsController@destroy');

get('accounts/{account}', 'AccountsController@show');

get('user/{user}', 'UserProfileController@show');




Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

//--SQL query log--//
if (Config::get('database.log', false))
{
    Event::listen('illuminate.query', function($query, $bindings, $time, $name)
    {
        $data = compact('bindings', 'time', 'name');

        // Format binding data for sql insertion
        foreach ($bindings as $i => $binding)
        {
            if ($binding instanceof \DateTime)
            {
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            }
            else if (is_string($binding))
            {
                $bindings[$i] = "'$binding'";
            }
        }

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings);

        Log::info($query, $data);
    });
}