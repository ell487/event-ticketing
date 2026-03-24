<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'description',
        'banner_path',
        'location',
        'event_date',
        'status'
    ];

    // Relasi: "Satu user sebagai organizer
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relasi: "Satu Event bisa punya BANYAK jenis tiket"
    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'event_id');
    }

    // Relasi: "Satu Event memiliki Satu Kategori"
    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id');
    }
}
