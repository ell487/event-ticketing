<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organizer_id',
        'category_id',
        'event_title',
        'description',
        'banner',
        'location',
        'event_date',
        'event_status',
    ];
}
