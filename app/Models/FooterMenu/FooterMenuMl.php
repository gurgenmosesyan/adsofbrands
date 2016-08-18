<?php

namespace App\Models\FooterMenu;

use App\Core\Model;

class FooterMenuMl extends Model
{
    protected $table = 'footer_menu_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'text'
    ];
}