@extends('app')
{{--
<ul>
@foreach($orders as $order)
    <li>[{{$order->created_at->diffForHumans()}}]ID:{{$order->id}} / {{$order->buyer->name}} / {{$order->account->league}}{{$order->account->division}}</li>
@endforeach
</ul>
--}}
@section('content')
<div id="cucc"></div>
@endsection

@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>

<script>
    var socket = io('http://market.dev:6001');
    socket.on('test-chanel:App\\Events\\TradeStatusChangedEvent', function(message){
        // increase the power everytime we load test route
        //$('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        console.log(message);
    });
</script>
@endsection