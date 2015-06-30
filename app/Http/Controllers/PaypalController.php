<?php

namespace App\Http\Controllers;

use App\Account;
use App\Services\PaymentService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaypalController extends Controller
{
    function __construct()
    {
        $this->middleware('auth',['only' => 'pay']);
    }
    public function pay(PaymentService $paypal, Account $account)
    {
        return  $paypal
                    ->order($account)
                    ->sendPayment()
                    ->setPaymentOptions()
        ;
    }
}
