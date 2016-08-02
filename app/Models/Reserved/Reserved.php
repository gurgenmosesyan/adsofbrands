<?php

namespace App\Models\Reserved;

use App\Core\Model;

class Reserved extends Model
{
    const TYPE_CASH = 'cash';
    const TYPE_AMERIA = 'ameria';
    const TYPE_ADMIN = 'admin';

    protected $fillable = [
        'accommodation_id',
        'room_quantity',
        'date_from',
        'date_to'
    ];

    protected $table = 'reserved';
}