@extends('app')

@section('content')
<div class="container">
            @foreach($accounts->chunk(6)->all() as $row)
                <div class="row  account_row">
                    @foreach($row as $account)
                        <div class="col-md-4 col-sm-6 account_list_item_wrapper">
                            <a href="{{asset('accounts/'.$account->id)}}" class="account_list_item {{$account->league}}" >

                                <div class="account_list_item_top" @include('accounts/partials/_background_badge',['account',$account])>
                                    <div class="price">
                                        ${{$account->price}}
                                    </div>
                                    <ul class="specs">
                                        <li>Server: {{$account->server}}</li>
                                        <li>Division: {{$account->league}} {{$account->division}}</li>
                                        <li>Champions: {{$account->champions}}</li>
                                        <li>Skins: {{$account->skins}}</li>
                                    </ul>
                                </div>
                                <div class="title">
                                    {{--<a href="{{asset('accounts/'.$account->id)}}">{{$account->title}}</a>--}}
                                    {{$account->title}}
                                </div>
                                <div class="seller_info">
                                    <b>- {{$account->user->name}}</b>
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
</div>
@endsection
