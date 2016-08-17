<?php

namespace App\Models\Commercial;

use App\Core\Model;

class CommercialAdvertising extends Model
{
    protected $table = 'commercial_advertising';

    public $timestamps = false;

    protected $fillable = [
        'commercial_id',
        'name',
        'link'
    ];
}