@extends('app')
@section('content')
    <div class="container">
        @if($orders)
        <div class="orders row">
            <h1>Your orders</h1>
            <ul>
                @foreach($orders as $order)
                    <li><a href="{{url('orders/'.$order->id)}}">[{{$order->created_at->diffForHumans()}}]ID:{{$order->id}} / {{$order->buyer->name}} / {{$order->account->league}}{{$order->account->division}}</a></li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <h1>{{$user->name}}'s Accounts</h1>
            @include('accounts/partials/_accountlist', ['accounts' => $accounts, 'profile_page'=>true, 'user'=>$user])
        </div>
    </div>
    @endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $( ".account_list_item" ).click(function() {
                $(location).attr('href',$(this).data('href'));
            });
            $('div.view').css({
                'position' : 'absolute',
                'top' : '50%',
                'margin-top' : -$('div.view').height()/2
            });
        });
    </script>

@endsection