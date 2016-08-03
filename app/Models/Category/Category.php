<?php

namespace App\Models\Category;

use App\Core\Model;

class Category extends Model
{
    protected $fillable = [];

    protected $table = 'categories';

    public function ml()
    {
        return $this->hasMany(CategoryMl::class, 'id', 'id');
    }
}