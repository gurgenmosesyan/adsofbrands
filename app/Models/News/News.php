<?php

namespace App\Models\News;

use App\Core\Model;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Creative\Creative;

class News extends Model
{
    const IMAGES_PATH = 'images/news';
    const TOP = '1';
    const NOT_TOP = '0';

    protected $fillable = [
        'alias',
        'top',
        'date'
    ];

    protected $table = 'news';

    public function isTop()
    {
        return $this->top == self::TOP;
    }

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function ml()
    {
        return $this->hasMany(NewsMl::class, 'id', 'id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'news_brands', 'news_id', 'brand_id');
    }

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'news_agencies', 'news_id', 'agency_id');
    }

    public function creatives()
    {
        return $this->belongsToMany(Creative::class, 'news_creatives', 'news_id', 'creative_id');
    }

    public function getFile($column)
    {
        return $this->$column;
    }

    public function setFile($file, $column)
    {
        $this->attributes[$column] = $file;
    }

    public function getStorePath()
    {
        return self::IMAGES_PATH;
    }
}