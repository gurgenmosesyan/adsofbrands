<?php

namespace App\Models\AgencyCategory;

use App\Core\Model;

class Category extends Model
{
    public $adminInfo = true;

    protected $fillable = [];

    protected $table = 'agency_categories';

    public function ml()
    {
        return $this->hasMany(CategoryMl::class, 'id', 'id');
    }
}