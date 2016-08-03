<?php

namespace App\Models\MediaType;

use App\Core\Model;

class MediaTypeMl extends Model
{
    protected $table = 'media_types_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title'
    ];
}