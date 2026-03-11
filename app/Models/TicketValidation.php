<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketValidation extends Model
{
    protected $fillable = [
        'ticket_id',
        'validated_by',
        'validation_date',
        'validation_status',
    ];
}
