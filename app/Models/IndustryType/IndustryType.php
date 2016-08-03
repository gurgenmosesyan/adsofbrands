<?php

namespace App\Models\IndustryType;

use App\Core\Model;

class IndustryType extends Model
{
    protected $fillable = [];

    protected $table = 'industry_types';

    public function ml()
    {
        return $this->hasMany(IndustryTypeMl::class, 'id', 'id');
    }
}