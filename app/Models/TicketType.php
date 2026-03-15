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

    // Relasi: "Satu jenis tiket ini milik satu Event tertentu"
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
