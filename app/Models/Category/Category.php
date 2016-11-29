<?php

namespace App\Models\Category;

use App\Core\Model;

class Category extends Model
{
    protected $fillable = [];

    public $adminInfo = true;

    protected $table = 'categories';

    public function ml()
    {
        return $this->hasMany(CategoryMl::class, 'id', 'id');
    }
}