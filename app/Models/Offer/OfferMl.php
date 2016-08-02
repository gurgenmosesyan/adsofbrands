<?php

namespace App\Models\Offer;

use App\Core\Model;

class OfferMl extends Model
{
    protected $table = 'offers_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'text'
    ];
}