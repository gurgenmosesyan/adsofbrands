<?php

namespace App\Models\Commercial;

use App\Core\Model;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;

class Commercial extends Model
{
    const IMAGES_PATH = 'images/commercial';
    const TYPE_VIDEO = 'video';
    const TYPE_PRINT = 'print';
    const VIDEO_TYPE_YOUTUBE = 'youtube';
    const VIDEO_TYPE_VIMEO = 'vimeo';
    const VIDEO_TYPE_FB = 'fb';
    const VIDEO_TYPE_EMBED = 'embed';
    const FEATURED = '1';
    const NOT_FEATURED = '0';
    const TOP = '1';
    const NOT_TOP = '0';

    protected $fillable = [
        'media_type_id',
        'industry_type_id',
        'country_id',
        'category_id',
        'alias',
        'type',
        'video_type',
        'video_data',
        'featured',
        'top',
        'advertising',
        'published_date',
        'views_count',
        'rating',
        'qt'
    ];

    protected $table = 'commercials';

    public function isVideo()
    {
        return $this->type == self::TYPE_VIDEO;
    }

    public function isPrint()
    {
        return $this->type == self::TYPE_PRINT;
    }

    public function isYoutube()
    {
        return $this->video_type == self::VIDEO_TYPE_YOUTUBE;
    }

    public function isVimeo()
    {
        return $this->video_type == self::VIDEO_TYPE_VIMEO;
    }

    public function isFb()
    {
        return $this->video_type == self::VIDEO_TYPE_FB;
    }

    public function isEmbed()
    {
        return $this->video_type == self::VIDEO_TYPE_EMBED;
    }

    public function isFeatured()
    {
        return $this->featured == self::FEATURED;
    }

    public function isTop()
    {
        return $this->top == self::TOP;
    }

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function getPrintImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image_print);
    }

    public function ml()
    {
        return $this->hasMany(CommercialMl::class, 'id', 'id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'commercial_brands', 'commercial_id', 'brand_id');
    }

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'commercial_agencies', 'commercial_id', 'agency_id');
    }

    public function advertisings()
    {
        return $this->hasMany(CommercialAdvertising::class, 'commercial_id', 'id');
    }

    public function credits()
    {
        return $this->hasMany(CommercialCredit::class, 'commercial_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany(CommercialTag::class, 'commercial_id', 'id');
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