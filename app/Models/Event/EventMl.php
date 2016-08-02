<?php

namespace App\Models\Event;

use App\Core\Model;

class EventMl extends Model
{
    protected $table = 'events_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'text'
    ];
}