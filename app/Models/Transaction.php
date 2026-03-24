<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'invoice_code',
        'expiration_date',
        'transaction_status'
    ];

    // Relasi balik ke User dan Event
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event() {
        return $this->belongsTo(Event::class);
    }
    // Transaksi ini punya banyak detail tiket
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
