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

use App\Events\TradeStatusChangedEvent;
//use Event;
use App\Order;

Route::get('/success', function(){
    return view('succes');
});
Route::get('/eventtest', function(){
    return view('test');
});

// End of test things


Route::get('/', 'AccountsController@index');
Route::get('home', 'HomeController@index');

//-- Account Resource routes --//
get('accounts', 'AccountsController@index');
get('accounts/create','AccountsController@create');
post('accounts/store','AccountsController@store');
get('accounts/{account}', 'AccountsController@show');
get('accounts/{account}/edit','AccountsController@edit');
patch('accounts/{account}','AccountsController@update');
delete('accounts/{account}','AccountsController@destroy');

//-- User routes --//
get('user/{user}', 'UserProfileController@show');

//Order & Feedback
get('trade/{order}','TradeController@show');
post('trade/{order}','TradeController@stepProcessor');
get('trade/{order}/steplist','TradeController@stepList');
post('trade/{order}/chat','TradeController@storeChatMessage');
//get('trade/{order}/chat','TradeController@storeChatMessage');


get('trade/reset/{order}',function($order){
    $order->SellerDelivered = 0;
    $order->BuyerCancelRequest = 0;
    $order->BuyerChecked =0;
    $order->save();
});

//Websocket
post('api/token/{order}','WebsocketController@tokenForTrade');
post('api/token','WebsocketController@token');
//get('api/token','WebsocketController@token');


//-- PayPal routes --//
get('api/order/{account}','PaypalController@pay');
post('api/ipn/{user}/{accountRep}','PaypalController@ipn');


//-- Auth routes --//
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