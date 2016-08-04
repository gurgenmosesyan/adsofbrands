<?php

namespace App\Models\Branch;

use App\Core\Model;

class BranchMl extends Model
{
    protected $table = 'branches_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'address'
    ];
}