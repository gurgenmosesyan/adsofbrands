<?php

namespace App\Models\Award;

use App\Core\Model;

class AwardMl extends Model
{
    protected $table = 'awards_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'category'
    ];
}