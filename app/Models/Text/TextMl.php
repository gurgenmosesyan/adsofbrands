<?php

namespace App\Models\Text;

use App\Core\Model;

class TextMl extends Model
{
    protected $table = 'texts_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'key',
        'text'
    ];

    public function scopeCurrent($query)
    {
        return $query->where('lng_id', cLng('id'));
    }
}