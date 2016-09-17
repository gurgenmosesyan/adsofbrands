<?php

namespace App\Models\Commercial;

use App\Core\Model;
use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Country\CountryMl;
use App\Models\Category\CategoryMl;
use App\Models\MediaType\MediaType;

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
        return url('/images/commercial_big/'.$this->image_print);
    }

    public function getOriginalImage()
    {
        return url('/images/commercial_origin/'.$this->image_print);
    }

    public function getLink()
    {
        return url_with_lng('/ads/'.$this->alias.'/'.$this->id);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('commercials.published_date', 'desc')->orderBy('commercials.id', 'desc');
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

    public function media_type()
    {
        return $this->belongsTo(MediaType::class, 'media_type_id', 'id');
    }

    public function category_ml()
    {
        return $this->belongsTo(CategoryMl::class, 'category_id', 'id')->current();
    }

    public function country_ml()
    {
        return $this->belongsTo(CountryMl::class, 'country_id', 'id')->current();
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