<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'transaction_detail_id',
        'ticket_code',
        'qr_code_path',
        'used_at',
    ];
}
