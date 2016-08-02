<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '2';
    const STATUS_DELETED = '0';

    public function scopeActive($query)
    {
        return $query->where('show_status', self::STATUS_ACTIVE);
    }
}