{{--Seller Pending--}}
<div class="row pending-row">
    <div class="trade trade-pending col-sm-8">
        <h3>Step 2</h3>
        <p>Deliver the account informations to the buyer.</p>
    </div>
    <div class="trade trade-opt-check trade-pending col-sm-2">
        <p>You succesfully delivered the account to the buyer.</p>
    </div>
    <div class="trade trade-opt-close trade-pending col-sm-2">
        <p>You can't deliver the account. Refund buyer.</p>
    </div>
</div>

{{--Buyer Pending, can't cancel--}}
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
<div class="row pending-row">
    <div class="trade trade-pending col-sm-10">
        <h3>Step 2</h3>
        <p>
            Waiting for the seller to deliver the account informations. <br>
            The seller ran out of the guaranteed delivery time. You can cancel your order,
            and get a refund, or wait for the seller to deliver your account.
        </p>
    </div>
    <div class="trade trade-opt-close trade-pending col-sm-2">
        <p>Cancel order, get refund.</p>
    </div>
</div>

{{--Buyer/Selelr,done--}}
<div class="row">
    <div class="trade trade-done col-sm-12">
        <h3>Step 2</h3>
        <p>
            The seller ({{$order->account->user->name}}) delivered the account.
        </p>
    </div>
</div>

{{--Buyer/Selelr ,Buyer cancel--}}
<div class="row">
    <div class="trade trade-error col-sm-12">
        <h3>Step 2</h3>
        <p>
            The buyer ({{$order->buyer->name}}) cancelled the order and get a refund.
        </p>
    </div>
</div>

{{--Buyer/Selelr,Seller cancel--}}
<div class="row">
    <div class="trade trade-error col-sm-12">
        <h3>Step 2</h3>
        <p>
            The seller ({{$order->account->user->name}}) can't deliver the account. The order is cancelled.
            Buyer ({{$order->buyer->name}}) will get refund.
        </p>
    </div>
</div>