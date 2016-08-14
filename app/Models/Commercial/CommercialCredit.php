<?php

namespace App\Models\Commercial;

use App\Core\Model;

class CommercialCredit extends Model
{
    protected $table = 'commercial_credits';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'commercial_id',
        'position',
        'sort_order'
    ];
}