<?php

namespace App\Models\Team;

use App\Core\Model;

class TeamMl extends Model
{
    protected $table = 'team_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'first_name',
        'last_name',
        'position'
    ];
}