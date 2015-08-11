@if($order->payed == 0 && ($order->SellerDelivered != 1 || $order->BuyerChecked != 1  ))
    <div class="row">
        <div class="trade trade-inactive col-sm-12">
            <h3>Step 4</h3>
            <p>We transfer the payment.</p>
        </div>
    </div>

@elseif($order->payed == 0 && $order->SellerDelivered == 1 && $order->BuyerChecked == 1)
    <div class="row">
        <div class="trade trade-pending col-sm-12">
            <h3>Step 4</h3>
            <p>We transfer the payment to the seller.</p>
        </div>
    </div>


@elseif($order->payed == 1)
    <div class="row">
        <div class="trade trade-done col-sm-12">
            <h3>Step 4</h3>
            <p>We transfered the payment to the seller.</p>
        </div>
    </div>


@elseif($order->payed == -1)
    <div class="row">
        <div class="trade trade-error col-sm-12">
            <h3>Step 4</h3>
            <p>We transfered the payment back to the buyer.</p>
        </div>
    </div>
@endif