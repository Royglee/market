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
                    <div class="pull-left item" data-toggle="tooltip" data-placement="top" title="Guaranteed delivery time">
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span>{{$account->delivery}}h</span>
                    </div>
                </div>
                @if(!$account->sold)
                <button class="buynow_b pull-right" id="buynow_button" data-href="{{action('PaypalController@pay',$account)}}">
                    <div class="buynow">
                        <span id="loading" class="glyphicon glyphicon-refresh hidden glyphicon-refresh-animate"></span>
                        Buy Now</div>
                    <div class="buynow_p">${{$account->price}}</div>
                </button>
                    @else
                    <div class="buynow_b pull-right">
                        <div class="buynow">Sold Out</div>
                    </div>
                @endif
                <form id="paypalform" action="https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay" target="PPDGFrame" class="hidden">
                    <input id="type" type="hidden" name="expType" value="light">
                    <input id="paykey" type="hidden" name="paykey" value="">
                </form>
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

@section('scripts')
    <script type="text/javascript" src="https://www.paypalobjects.com/js/external/dg.js"></script>
    <script type="text/javascript">
        var embeddedPPFlow1 = new PAYPAL.apps.DGFlow( {trigger : 'paypalform'});
    </script>
    @endsection