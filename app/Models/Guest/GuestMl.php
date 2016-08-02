<?php

namespace App\Models\Guest;

use App\Core\Model;

class GuestMl extends Model
{
    protected $table = 'guests_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'image',
        'name'
    ];

    public function scopeCurrent($query)
    {
        return $query->where('lng_id', cLng('id'));
    }

    public function getImage()
    {
        return url('/images/guest/'.$this->image);
    }
}