<?php

namespace App\Models\IndustryType;

use App\Core\Model;

class IndustryTypeMl extends Model
{
    protected $table = 'industry_types_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title'
    ];
}