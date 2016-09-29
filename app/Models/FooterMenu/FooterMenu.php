<?php

namespace App\Models\FooterMenu;

use App\Core\Model;

class FooterMenu extends Model
{
    const IS_STATIC = '1';
    const IS_NOT_STATIC = '0';
    const HIDDEN = '1';
    const NOT_HIDDEN = '0';

    protected $fillable = [
        'alias',
        'static',
        'hidden',
        'sort_order'
    ];

    protected $table = 'footer_menu';

    public function isStatic()
    {
        return $this->static == self::IS_STATIC;
    }

    public function isHidden()
    {
        return isset($this->attributes['hidden']) && $this->attributes['hidden'] == self::HIDDEN;
    }

    public function scopeVisible($query)
    {
        return $query->where('footer_menu.hidden', self::NOT_HIDDEN);
    }

    public function ml()
    {
        return $this->hasMany(FooterMenuMl::class, 'id', 'id');
    }
}