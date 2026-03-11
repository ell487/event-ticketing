<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'expiration_date',
        'transaction_date',
        'transaction_status'
    ];
}
