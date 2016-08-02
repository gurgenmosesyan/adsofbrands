<?php

namespace App\Models\Event;

use App\Core\Model;

class Event extends Model
{
    protected $fillable = [
        'sort_order'
    ];

    protected $table = 'events';

    public function scopeJoinMl($query)
    {
        return $query->join('events_ml as ml', function($query) {
            $query->on('ml.id', '=', 'events.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('events.sort_order', 'asc');
    }

    public function ml()
    {
        return $this->hasMany(EventMl::class, 'id', 'id');
    }
}