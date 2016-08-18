<?php

namespace App\Models\AgencyCategory;

use App\Core\Model;

class CategoryMl extends Model
{
    protected $table = 'agency_categories_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title'
    ];
}