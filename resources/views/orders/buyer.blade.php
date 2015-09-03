@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-4 trade-status-wrapper">
                <div class="trade-status">
                    <div class="row">
                        <div class="trade trade-status-title col-sm-12">
                            <h3>Chat</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="chat-area col-sm-12" id="chat-area">
                                @foreach($order->thread->messages as $message)
                                    <div  class="chat-message {{(Auth::user()==$message->user)?"left":"right"}}">{{$message->user->name}} : {{$message->body}}</div>
                                @endforeach
                            <div id="type-area" class=" col-sm-12 "></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="textarea-cont">
                            <textarea class="col-xs-12" name="message" id="chat" data-order="{{$order->id}}" data-name="{{Auth::user()->name}}" rows="1"></textarea>
                            <i id="chat-send" class="fa fa-paper-plane"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 trade-status-wrapper">
                   <div class="trade-status">
                       <div class="row">
                           <div class="trade trade-status-title col-sm-12">
                               <h3>
                                   Trade status
                                   <span id="refresh" class="glyphicon glyphicon-repeat pull-right" aria-hidden="true"></span>
                               </h3>
                           </div>
                       </div>
                       <div class="col-sm-12" id="tradelist">
                        @include('orders.partials.steps', ['order' => $order])
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
    <script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
    <script src="{{asset("js/trade.js")}}"></script>
@endsection