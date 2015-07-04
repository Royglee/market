<?php

namespace App\Http\Controllers;

use App\Account;
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
            $account->buyer($user)->sold($paypal->ipnMessage(true)['PayKey']);
        } else {
            Log::info("INVALID");
        }

    }
}
