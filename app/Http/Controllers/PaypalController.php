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
    public function pay(PaymentService $paypal, Account $account)
    {
        dd(
            $paypal
            ->order($account)
            ->sendPayment()
            ->PayPalResult_Pay
        );
    }
}
