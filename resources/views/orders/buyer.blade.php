@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-4 trade-status-wrapper">
                <div class="trade-status">
                    <div class="row">
                        <div class="trade trade-status-title col-sm-12">
                            <h3>Chat with Seller</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="chat-area col-sm-12">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 trade-status-wrapper">
                   <div class="trade-status">
                        <div class="row">
                            <div class="trade trade-status-title col-sm-12">
                                <h3>Trade status</h3>
                            </div>
                        </div>

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


                       <div class="row">
                           <div class="trade trade-inactive col-sm-12">
                               <h3>Step 5</h3>
                               <p>Send feedback</p>
                           </div>
                       </div>

                   </div>
            </div>
        </div>
        <div class="row" style="padding:10px">
            {{var_dump($order->toArray())}}
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function equal_cols(el)
        {
            if($(window).width() > 750) {
                $(el).each(function(){
                    var h = 0;
                    var elm = $(this).children();
                    $(elm).each(function () {
                        $(this).css({'height': 'auto'});
                        if ($(this).outerHeight() > h) {
                            h = $(this).outerHeight();
                        }
                    });
                    $(elm).css({'height': h});
                });

            }
            else{
                $(el).each(function () {
                    var elm = $(this).children();
                    $(elm).each(function () {
                        $(this).css({'height': 'auto'});
                    });
                });
            }
        }

        $( document ).ready(function() {
            equal_cols('.pending-row');
            $( window ).resize(function() {
                equal_cols('.pending-row');
            });
        });
    </script>
    @endsection