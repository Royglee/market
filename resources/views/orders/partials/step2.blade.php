{{--Seller Pending--}}
@if($order->isSeller && $order->SellerDelivered == 0 && $order->BuyerCancelRequest == 0)
<div class="row pending-row">
    <div class="trade trade-pending col-sm-8">
        <h3>Step 2</h3>
        <p>Deliver the account informations to the buyer.</p>
    </div>
    <div class="trade trade-opt-check trade-pending col-sm-2" data-opt="2.check">
        <p>You succesfully delivered the account to the buyer.</p>
    </div>
    <div class="trade trade-opt-close trade-pending col-sm-2" data-opt="2.cancel">
        <p>You can't deliver the account. Refund buyer.</p>
    </div>
</div>


{{--Buyer Pending, can't cancel--}}
@elseif($order->isBuyer && $order->SellerDelivered == 0 && !$order->delivery_exp)
<div class="row pending-row">
    <div class="trade trade-pending col-sm-12">
        <h3>Step 2</h3>
        <p>
            Waiting for the seller to deliver the account informations.
            If the seller won't deliver it in {{$order->account->delivery}} hours, you can cancel your order,
            and get a refund.
        </p>
    </div>
</div>


{{--Buyer Pending, can cancel--}}
@elseif($order->isBuyer && $order->SellerDelivered == 0 && $order->delivery_exp && $order->BuyerCancelRequest == 0)
<div class="row pending-row">
    <div class="trade trade-pending col-sm-10">
        <h3>Step 2</h3>
        <p>
            Waiting for the seller to deliver the account informations. <br>
            The seller ran out of the guaranteed delivery time. You can cancel your order,
            and get a refund, or wait for the seller to deliver your account.
        </p>
    </div>
    <div class="trade trade-opt-close trade-pending col-sm-2" data-opt="2.cancel">
        <p>Cancel order, get refund.</p>
    </div>
</div>

{{--Buyer/Selelr,done--}}
@elseif($order->SellerDelivered == 1)
<div class="row">
    <div class="trade trade-done col-sm-12">
        <h3>Step 2</h3>
        <p>
            The seller ({{$order->seller->name}}) delivered the account.
        </p>
    </div>
</div>

{{--Buyer/Selelr ,Buyer cancel--}}
@elseif($order->SellerDelivered == 0 && $order->delivery_exp && $order->BuyerCancelRequest == 1)
<div class="row">
    <div class="trade trade-error col-sm-12">
        <h3>Step 2</h3>
        <p>
            The buyer ({{$order->buyer->name}}) cancelled the order and get a refund.
        </p>
    </div>
</div>

{{--Buyer/Selelr,Seller cancel--}}
@elseif($order->SellerDelivered == -1)
<div class="row">
    <div class="trade trade-error col-sm-12">
        <h3>Step 2</h3>
        <p>
            The seller ({{$order->seller->name}}) can't deliver the account. The order is cancelled.
            Buyer ({{$order->buyer->name}}) will get refund.
        </p>
    </div>
</div>
@endif