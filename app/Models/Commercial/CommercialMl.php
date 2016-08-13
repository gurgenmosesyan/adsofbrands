<?php

namespace App\Models\Commercial;

use App\Core\Model;

class CommercialMl extends Model
{
    protected $table = 'commercials_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'description'
    ];
}