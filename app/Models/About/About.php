<?php

namespace App\Models\About;

use App\Core\Model;

class About extends Model
{
    protected $table = 'about';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'text'
    ];

    public function scopeCurrent($query)
    {
        return $query->where('lng_id', cLng('id'));
    }
}