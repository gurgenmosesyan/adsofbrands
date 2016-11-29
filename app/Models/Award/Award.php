<?php

namespace App\Models\Award;

use App\Core\Model;

class Award extends Model
{
    const TYPE_BRAND = 'brand';
    const TYPE_AGENCY = 'agency';
    const TYPE_CREATIVE = 'creative';

    public $adminInfo = true;

    protected $fillable = [
        'type',
        'type_id',
        'year'
    ];

    protected $table = 'awards';

    public function isBrand()
    {
        return $this->type == self::TYPE_BRAND;
    }

    public function isAgency()
    {
        return $this->type == self::TYPE_AGENCY;
    }

    public function isCreative()
    {
        return $this->type == self::TYPE_CREATIVE;
    }

    public function ml()
    {
        return $this->hasMany(AwardMl::class, 'id', 'id');
    }
}