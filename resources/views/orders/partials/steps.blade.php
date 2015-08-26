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


<div class="row pending-row">
    {{--<div class="trade trade-inactive col-sm-12">--}}
        {{--<h3>Step 5</h3>--}}
        {{--<p>Send feedback</p>--}}
    {{--</div>--}}
    <div class="trade trade-pending col-sm-6">
        <h3>Step 5</h3>
        <p>Send feedback</p>
    </div>
    <div class="trade trade-pending trade-feedback-column col-sm-6">
        <h4>Choose one...</h4>
        <button type="button" class="btn btn-default btn-circle btn-lg fb-pos"><i class="fa fa-smile-o"></i></button>
        <button type="button" class="btn btn-default btn-circle btn-lg fb-neu"><i class="fa fa-meh-o"></i></button>
        <button type="button" class="btn btn-default btn-circle btn-lg fb-neg"><i class="fa fa-frown-o"></i></button>

        <h4>Write a short review:</h4>
        <textarea class="form-control" placeholder="Write a short review here..." spellcheck="false" name="review" id="review" cols="40" rows="2"></textarea>
        <a href="#" class="btn btn-outlined btn-white btn-sm" data-wow-delay="0.7s">Send Feedback</a>
    </div>
</div>