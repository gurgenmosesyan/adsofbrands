<?php

namespace App\Models\Accommodation;

use App\Core\Model;

class AccommodationDetail extends Model
{
    protected $table = 'accommodation_details';

    public $timestamps = false;

    protected $fillable = [
        'accommodation_id',
        'lng_id',
        'title',
        'price',
        'index'
    ];

    public function scopeCurrent($query)
    {
        return $query->where('lng_id', cLng('id'));
    }
}