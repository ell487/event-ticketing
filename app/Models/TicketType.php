<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = [
        'event_id',
        'type_name',
        'price',
        'quota',
        'sold_quantity',
    ];
}
