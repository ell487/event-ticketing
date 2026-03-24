<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'ticket_type_id',
        'quantity',
    ];

    // Relasi balik ke Induk Transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke Jenis Tiket (biar tahu ini tiket VIP atau Regular)
    public function ticket()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    // Detail transaksi bisa punya banyak tiket (tergantung quantity)
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'transaction_detail_id');
    }
}
