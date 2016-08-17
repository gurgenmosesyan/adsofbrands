<?php

namespace App\Models\Commercial;

use App\Core\Model;

class CommercialCreditPerson extends Model
{
    const TYPE_CREATIVE = 'creative';
    const TYPE_BRAND = 'brand';
    const TYPE_AGENCY = 'agency';

    protected $table = 'commercial_credit_persons';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'type_id',
        'name',
        'separator'
    ];

    public function isCreative()
    {
        return $this->type == self::TYPE_CREATIVE;
    }

    public function isBrand()
    {
        return $this->type == self::TYPE_BRAND;
    }

    public function isAgency()
    {
        return $this->type == self::TYPE_AGENCY;
    }
}