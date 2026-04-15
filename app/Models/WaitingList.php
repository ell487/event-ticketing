<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    
}
