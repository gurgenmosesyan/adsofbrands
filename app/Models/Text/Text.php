<?php

namespace App\Models\Text;

use App\Core\Model;

class Text extends Model
{
    const KEY_ABOUT = 'about';
    const KEY_PRODUCTS = 'products';
    const KEY_PARTNERS = 'partners';
    const KEY_CONTACT = 'contact';

    protected $table = 'texts';

    protected $fillable = [
        'key'
    ];

    public function ml()
    {
        return $this->hasMany(TextMl::class, 'id', 'id');
    }
}