@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="head_title {{$account->league}}" @include('accounts/partials/_background_badge',['account',$account])>
                <h1 class="dp_acc_title {{$account->league}}_title_font">{{$account->title}}</h1>
            </div>
            <div class="head_title_ir">
                <div class="acc_meta">
                    <div class="pull-left item" data-toggle="tooltip" data-placement="top" title="Number of views">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    <span>{{$account->view_count}}</span>
                    </div>
                    <div class="pull-left item" data-toggle="tooltip" data-placement="top" title="Time left">
                        <span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span>
                        <span>{{$account->created_at->addDays($account->duration)->diffForHumans()}}</span>
                    </div>
                </div>
                <button class="buynow_b pull-right">
                    <div class="buynow">Buy Now</div>
                    <div class="buynow_p">${{$account->price}}</div>
                </button>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="account_details row">
            <div class="account_details_i col-sm-3">
                <div class="order_d">
                    <h3>Order Details</h3>
                    <ul class="specs">
                        <li>Server: {{$account->server}}</li>
                        <li>Division: {{$account->league}} {{$account->division}}</li>
                        <li>Champions: {{$account->champions}}</li>
                        <li>Skins: {{$account->skins}}</li>
                    </ul>
                </div>
            </div>
            <div class="account_details_b col-sm-9">
                <h3>Description</h3>
                {!! $account->body !!}
            </div>
        </div>


        <div>

        </div>
    </div>
@endsection