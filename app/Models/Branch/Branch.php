<?php

namespace App\Models\Branch;

use App\Core\Model;

class Branch extends Model
{
    const TYPE_BRAND = 'brand';
    const TYPE_AGENCY = 'agency';

    protected $fillable = [
        'type',
        'type_id',
        'phone',
        'email',
        'lat',
        'lng'
    ];

    protected $table = 'branches';

    public function isBrand()
    {
        return $this->type == self::TYPE_BRAND;
    }

    public function ml()
    {
        return $this->hasMany(BranchMl::class, 'id', 'id');
    }
}