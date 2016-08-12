<?php

namespace App\Models\News;

use App\Core\Model;

class NewsMl extends Model
{
    protected $table = 'news_ml';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'lng_id',
        'title',
        'sub_title',
        'text',
    ];
}