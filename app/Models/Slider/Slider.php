<?php

namespace App\Models\Slider;

use App\Core\Model;

class Slider extends Model
{
    const KEY_OFFERS = 'offers';
    const KEY_FACILITIES = 'facilities';
    const KEY_EVENTS = 'events';

    protected $table = 'slider';

    public $timestamps = false;

    protected $fillable = [
        'key',
        'facility_id',
        'sort_order'
    ];
}