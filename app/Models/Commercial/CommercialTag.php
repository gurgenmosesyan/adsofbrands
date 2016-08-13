<?php

namespace App\Models\Commercial;

use App\Core\Model;

class CommercialTag extends Model
{
    protected $table = 'commercial_tags';

    public $timestamps = false;

    protected $fillable = [
        'tag'
    ];
}