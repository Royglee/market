<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Account;

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
 */
class Order extends Model
{
    protected $appends = array('delivery_exp');

    public function getDeliveryExpAttribute()
    {
        return $this->created_at->addHours($this->account->delivery)->isPast();
    }
    public function buyer()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}
