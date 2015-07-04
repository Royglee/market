<ul>
@foreach($orders as $order)
    <li>[{{$order->created_at->diffForHumans()}}]ID:{{$order->id}} / {{$order->buyer->name}} / {{$order->account->league}}{{$order->account->division}}</li>
@endforeach
</ul>