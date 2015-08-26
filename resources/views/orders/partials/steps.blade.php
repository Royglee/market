<div class="row">
    <div class="trade trade-done col-sm-12">
        <h3>Step 1</h3>
        <p>
            {{$order->buyer->name}} succesfully ordered an account for ${{$order->account->price}} <br>
            Server: {{$order->account->server}} | Champions: {{$order->account->champions}}
            | Skins: {{$order->account->skins}} | Division: {{$order->account->league}} {{$order->account->division}}
        </p>
    </div>
</div>
@include('orders.partials.step2', ['order' => $order])
@include('orders.partials.step3', ['order' => $order])
@include('orders.partials.step4', ['order' => $order])
@include('orders.partials.step5', ['order' => $order])

