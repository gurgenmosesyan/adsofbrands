<?php

namespace App\Models\Homepage;

use App\Core\Model;

class HomepageMl extends Model
{
    protected $table = 'homepage_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'about_text',
        'offers_text'
    ];
}