<?php

namespace App\Http\Controllers;

use App\Jobs\ExecutePayment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TradeController extends Controller
{

    public function show($order)
    {

        return view('orders.buyer', compact('order'));
    }

    public function stepProcessor($order, Request $request)
    {
        $commandArray = $request->all();
        if($order->isSeller){
            if($commandArray['step']==2){
                if($commandArray['action']=='check' && $order->SellerDelivered == 0 && $order->BuyerCancelRequest == 0){
                    $order->SellerDelivered = 1;
                    $order->save();
                    return 200;
                }
                elseif($commandArray['action']=='cancel' && $order->SellerDelivered == 0 && $order->BuyerCancelRequest == 0){
                    $order->SellerDelivered = -1;
                    $order->save();
                    return 200;
                }
            }
        }
        if($order->isBuyer){
            if($commandArray['step']==2){
                if($commandArray['action']=='cancel' && $order->SellerDelivered == 0 && $order->BuyerCancelRequest == 0){
                    $order->BuyerCancelRequest = 1;
                    $order->save();
                    return 200;
                }
            }
            if($commandArray['step']==3){
                if($commandArray['action']=='check' && $order->SellerDelivered == 1 && $order->BuyerChecked == 0){
                    $order->BuyerChecked = 1;
                    $order->save();

                    $this->dispatch(new ExecutePayment($order));
                    return 200;
                }
                elseif($commandArray['action']=='error' && $order->SellerDelivered == 1 && $order->BuyerChecked == 0){
                    $order->BuyerChecked = -1;
                    $order->save();
                    return 200;
                }
            }

        }

        abort(400);
    }

    public function stepList($order)
    {

        return view('orders.partials.steps', compact('order'));
    }

}
