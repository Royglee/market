<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cmgmyr\Messenger\Traits\Messagable;

/**
 * @property mixed orders
 * @property mixed sold_accounts
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Messagable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function accounts()
    {
        return $this->hasMany('App\Account');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function sold_accounts()
    {
        return $this->hasMany('App\Order','seller_user_id');
    }
    public function feedbacks()
    {
        return $this->hasMany('App\Feedback','receiver_id');
    }
    public function feedbacks_sent()
    {
        return $this->hasMany('App\Feedback','sender_id');
    }
}
