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
        'credit_id',
        'type',
        'type_id',
        'name',
        'separator'
    ];
}