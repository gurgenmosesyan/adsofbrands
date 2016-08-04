<?php

namespace App\Models\Agency;

use App\Core\Model;

class AgencyMl extends Model
{
    protected $table = 'agencies_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'sub_title',
        'about',
        'address'
    ];
}