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
 */
class Order extends Model
{
    protected $appends = array('delivery_exp','isSeller','isBuyer');

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
}
