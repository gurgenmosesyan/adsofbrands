<?php

namespace App\Models\ShortLink;

use App\Core\Model;

class ShortLink extends Model
{
    public $adminInfo = true;

    protected $fillable = [
        'short_link',
        'link',
    ];

    protected $table = 'short_links';
}