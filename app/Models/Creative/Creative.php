<?php

namespace App\Models\Creative;

use App\Core\Model;

class Creative extends Model
{
    const TYPE_PERSONAL = 'personal';
    const TYPE_BRAND = 'brand';
    const TYPE_AGENCY = 'agency';

    protected $fillable = [
        'type',
        'type_id'
    ];

    protected $table = 'creatives';

    public function isPersonal()
    {
        return $this->type == self::TYPE_PERSONAL;
    }

    public function isBrand()
    {
        return $this->type == self::TYPE_BRAND;
    }

    public function isAgency()
    {
        return $this->type == self::TYPE_AGENCY;
    }

    public function ml()
    {
        return $this->hasMany(CreativeMl::class, 'id', 'id');
    }
}