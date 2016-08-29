<?php

namespace App\Models\FooterMenu;

use App\Core\Model;

class FooterMenu extends Model
{
    const IS_STATIC = '1';
    const IS_NOT_STATIC = '0';

    protected $fillable = [
        'alias',
        'static',
        'sort_order'
    ];

    protected $table = 'footer_menu';

    public function isStatic()
    {
        return $this->static == self::IS_STATIC;
    }

    public function ml()
    {
        return $this->hasMany(FooterMenuMl::class, 'id', 'id');
    }
}