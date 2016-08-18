<?php

namespace App\Models\FooterMenu;

use App\Core\Model;

class FooterMenu extends Model
{
    protected $fillable = [];

    protected $table = 'footer_menu';

    public function ml()
    {
        return $this->hasMany(FooterMenuMl::class, 'id', 'id');
    }
}