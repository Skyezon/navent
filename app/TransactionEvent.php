<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionEvent extends Model
{
    protected $fillable = ["member_id", "event_id", "quantity", "promo_id"];
}
