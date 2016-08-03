<?php

namespace App\Models\Category;

use App\Core\Model;

class CategoryMl extends Model
{
    protected $table = 'categories_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title'
    ];
}