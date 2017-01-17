<?php

namespace App\Models\Commercial;

use App\Core\Model;

class CommercialCredit extends Model
{
    protected $table = 'commercial_credits';

    public $timestamps = false;

    protected $fillable = [
        'commercial_id',
        'position',
        'sort_order'
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('commercial_credits.sort_order', 'asc')->orderBy('commercial_credits.id', 'asc');
    }

    public function persons()
    {
        return $this->hasMany(CommercialCreditPerson::class, 'credit_id', 'id');
    }
}