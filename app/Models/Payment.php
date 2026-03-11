<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'gateway_reference',
        'amount_paid',
        'payment_channel',
        'payment_status',
        'payment_date',
    ];
}
