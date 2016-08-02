<?php

namespace App\Models\Order;

use App\Core\Model;

class OrderAccommodation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'accommodation_id'
    ];

    protected $table = 'order_accommodations';
}