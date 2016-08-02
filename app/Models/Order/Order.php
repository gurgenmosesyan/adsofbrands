<?php

namespace App\Models\Order;

use App\Core\Model;

class Order extends Model
{
    const TYPE_CASH = 'cash';
    const TYPE_AMERIA = 'ameria';

    const STATUS_NOT_PAYED = 'not_payed';
    const STATUS_PAYED = 'payed';

    protected $fillable = [
        'type',
        'payment_id',
        'accommodations',
        'price',
        'date_from',
        'date_to',
        'info',
        'phone',
        'email',
        'status'
    ];

    protected $table = 'orders';

    public function accommodations()
    {
        return $this->hasMany(OrderAccommodation::class, 'order_id', 'id');
    }
}