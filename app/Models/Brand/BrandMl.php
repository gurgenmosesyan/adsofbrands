<?php

namespace App\Models\Brand;

use App\Core\Model;

class BrandMl extends Model
{
    protected $table = 'brands_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'description',
        'address'
    ];
}