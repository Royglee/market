@extends('app')

@section('content')
    <div class="container">
        <div>Account:{{$account->toJson()}}</div>
        <div>User:{{$account->user}}</div>

        <div>
            {!! $account->body !!}
        </div>
    </div>
@endsection