@if(!($order->SellerDelivered ==1 && $order->BuyerChecked ==1) && $order->closed == 0)
<div class="row pending-row">
    <div class="trade trade-inactive col-sm-12">
        <h3>Step 5</h3>
        <p>Send feedback</p>
    </div>
</div>
@endif

@if((($order->SellerDelivered ==1 && $order->BuyerChecked ==1) || $order->closed == 1) && !$order->feedbackSent)
    <div class="row pending-row">

    <div class="trade trade-pending col-sm-6">
        <h3>Step 5</h3>
        <p>Help the community by sending feedback to {{$order->partnerName}}.</p>

    </div>
    <div class="trade trade-pending trade-feedback-column col-sm-6">
        <h4>Choose one...</h4>
        <button type="button" class="btn btn-default btn-circle btn-lg fb-pos" data-feedback="positive"><i class="fa fa-smile-o"></i></button>
        <button type="button" class="btn btn-default btn-circle btn-lg fb-neu" data-feedback="neutral"><i class="fa fa-meh-o"></i></button>
        <button type="button" class="btn btn-default btn-circle btn-lg fb-neg" data-feedback="negative"><i class="fa fa-frown-o"></i></button>
        <input type="hidden" value="" id="feedback" name="feedback">

        <h4>Write a short review:</h4>
        <textarea class="form-control" placeholder="Write a short review here..." spellcheck="false" name="review" id="review" cols="40" rows="2" required></textarea>
        <div class="btn btn-outlined btn-white btn-sm" data-wow-delay="0.7s" data-opt="5.feedback">Send Feedback</div>
    </div>
</div>
@endif

@if((($order->SellerDelivered ==1 && $order->BuyerChecked ==1) ||
      $order->closed == 1) && $order->feedbackSent && !$order->partnerFeedbackSent)
<div class="row pending-row">

    <div class="trade trade-pending col-sm-6">
        <h3>Step 5</h3>
        <p>Waiting for {{$order->isBuyer?$order->seller->name:$order->buyer->name}}'s feedback.</p>
    </div>
    <div class="trade bg-{{$order->authUserFeedback()->feedback}} trade-feedback-column col-sm-6">
        <h4>You sent a {{$order->authUserFeedback()->feedback}} feedback to {{$order->partnerName}}</h4>
        <div class="feedback_wr">
            <div class="feedback_ei">
                @if($order->authUserFeedback()->feedback == "positive")
                    <span class="btn btn-default btn-circle btn-lg fb-pos selected"><i class="fa fa-smile-o"></i></span>
                @elseif($order->authUserFeedback()->feedback == "neutral")
                    <span class="btn btn-default btn-circle btn-lg fb-neu selected"><i class="fa fa-meh-o"></i></span>
                @elseif($order->authUserFeedback()->feedback == "negative")
                    <span class="btn btn-default btn-circle btn-lg fb-neg selected"><i class="fa fa-frown-o"></i></span>
                @endif
            </div>
            <div class="sent-review">{{$order->authUserFeedback()->review}}</div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
@endif

@if((($order->SellerDelivered ==1 && $order->BuyerChecked ==1) ||
      $order->closed == 1) && $order->feedbackSent && $order->partnerFeedbackSent)
<div class="row pending-row">

    <div class="trade bg-{{$order->partnersFeedback()->feedback}} col-sm-6">
        <h4>{{$order->partnerName}} sent a {{$order->partnersFeedback()->feedback}} feedback to you</h4>
        <div class="feedback_wr">
            <div class="feedback_ei">
                @if($order->partnersFeedback()->feedback == "positive")
                    <span class="btn btn-default btn-circle btn-lg fb-pos selected"><i class="fa fa-smile-o"></i></span>
                @elseif($order->partnersFeedback()->feedback == "neutral")
                    <span class="btn btn-default btn-circle btn-lg fb-neu selected"><i class="fa fa-meh-o"></i></span>
                @elseif($order->partnersFeedback()->feedback == "negative")
                    <span class="btn btn-default btn-circle btn-lg fb-neg selected"><i class="fa fa-frown-o"></i></span>
                @endif
            </div>
            <div class="sent-review">{{$order->partnersFeedback()->review}}</div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="trade bg-{{$order->authUserFeedback()->feedback}} trade-feedback-column col-sm-6">
        <h4>You sent a {{$order->authUserFeedback()->feedback}} feedback to {{$order->partnerName}}</h4>
        <div class="feedback_wr">
            <div class="feedback_ei">
                @if($order->authUserFeedback()->feedback == "positive")
                    <span class="btn btn-default btn-circle btn-lg fb-pos selected"><i class="fa fa-smile-o"></i></span>
                @elseif($order->authUserFeedback()->feedback == "neutral")
                    <span class="btn btn-default btn-circle btn-lg fb-neu selected"><i class="fa fa-meh-o"></i></span>
                @elseif($order->authUserFeedback()->feedback == "negative")
                    <span class="btn btn-default btn-circle btn-lg fb-neg selected"><i class="fa fa-frown-o"></i></span>
                @endif
            </div>
            <div class="sent-review">{{$order->authUserFeedback()->review}}</div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
    @endif
