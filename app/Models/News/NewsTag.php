<?php

namespace App\Models\News;

use App\Core\Model;

class NewsTag extends Model
{
    protected $table = 'news_tags';

    public $timestamps = false;

    protected $fillable = [
        'tag'
    ];
}