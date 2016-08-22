<?php

namespace App\Models\Creative;

use App\Core\Model;

class CreativeMl extends Model
{
    protected $table = 'creatives_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'about'
    ];
}