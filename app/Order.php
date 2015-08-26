<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Account;
use Illuminate\Support\Facades\Auth;

/**
 * @property Account account
 * @property Account user
 * @property mixed payKey
 * @property mixed user_id
 * @property int account_id
 * @property  seller_user_id
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo seller_user_id
 * @property mixed created_at
 * @property mixed acount
 * @property mixed seller
 * @property mixed buyer
 * @property mixed thread_id
 * @property mixed BuyerSentFeedback
 * @property mixed SellerSentFeedback
 */
class Order extends Model
{
    protected $appends = array('delivery_exp','isSeller','isBuyer','feedbackSent','PartnerFeedbackSent');

    public function getDeliveryExpAttribute()
    {
        return $this->created_at->addHours($this->account->delivery)->isPast();
    }
    public function getIsSellerAttribute()
    {
        return $this->seller == Auth::user();
    }
    public function getIsBuyerAttribute()
    {
        return $this->buyer == Auth::user();
    }
    public function getFeedbackSentAttribute()
    {
        return (($this->isBuyer && $this->BuyerSentFeedback == 1)||($this->isSeller && $this->SellerSentFeedback == 1));
    }
    public function getPartnerFeedbackSentAttribute()
    {
        return (($this->isBuyer && $this->SellerSentFeedback == 1)||($this->isSeller && $this->BuyerSentFeedback == 1));
    }
    public function getPartnerNameAttribute()
    {
        return $this->isBuyer?$this->seller->name:$this->buyer->name;
    }

    public function buyer()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function seller()
    {
        return $this->belongsTo('App\User','seller_user_id','id');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function thread()
    {
        return $this->belongsTo('Cmgmyr\Messenger\Models\Thread');
    }
    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }
    public function authUserFeedback()
    {
        return $this->hasMany('App\Feedback')->where('sender_id','=',Auth::user()->id)->first();
    }
    public function partnersFeedback()
    {
        return $this->hasMany('App\Feedback')->where('sender_id','!=',Auth::user()->id)->first();
    }

}
