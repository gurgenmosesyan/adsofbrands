<?php

namespace App\Models\Offer;

use App\Core\Model;

class Offer extends Model
{
    protected $fillable = [
        'sort_order'
    ];

    protected $table = 'offers';

    public function scopeJoinMl($query)
    {
        return $query->join('offers_ml as ml', function($query) {
            $query->on('ml.id', '=', 'offers.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('offers.sort_order', 'asc');
    }

    public function ml()
    {
        return $this->hasMany(OfferMl::class, 'id', 'id');
    }
}