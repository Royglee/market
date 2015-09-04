<?php

namespace App\Http\Controllers;

use App\Account;
use App\Events\TradeStatusChangedEvent;
use Event;
use App\Order;
use App\Repositories\AccountRepository;
use App\Services\PaymentService;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;


class PaypalController extends Controller
{
    function __construct()
    {
        $this->middleware('auth',['only' => 'pay']);
    }
    public function pay(PaymentService $paypal, Account $account)
    {
        if ($account->user_id == Auth::user()->id){
            abort(400,"You can't buy your own account");
        }
        if (!$account->sold) {
            return $paypal
                ->order($account)
                ->sendPayment()
                ->setPaymentOptions(); //PayKey
        }
    }

    public function ipn( User $user, AccountRepository $account, PaymentService $paypal)
    {
        if($paypal->isIPNVerified()){
            $IPNMessage = $paypal->ipnMessage(true);
            //Log::info($IPNMessage);
            if($IPNMessage['status'] == 'INCOMPLETE' && !Order::where('payKey', $IPNMessage['pay_key'])->exists()){
                $account->buyer($user)->sold($IPNMessage['pay_key']);
            }
            elseif($IPNMessage['status'] == 'COMPLETED' && $IPNMessage['transaction[1].status'] == 'Completed'){
                Log::info("Execute Payment IPN érkezett PayKey: ".$IPNMessage['pay_key']);

                $order = new Order();
                $order =$order->where('payKey', $IPNMessage['pay_key'])->first();
                $order->paid = 1;
                $order->save();
                Event::fire(new TradeStatusChangedEvent([$order->seller->id, $order->buyer->id], $order->id));
            }
        } else {
            Log::info("INVALID");
        }

    }
}
