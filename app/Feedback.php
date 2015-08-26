<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['feedback','review','sender_id','receiver_id','order_id'];
}
