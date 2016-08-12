<?php

namespace App\Models\Commercial;

use App\Core\Model;

class Commercial extends Model
{
    const IMAGES_PATH = 'images/commercial';
    const FEATURED = '1';
    const NOT_FEATURED = '0';
    const TOP = '1';
    const NOT_TOP = '0';

    protected $fillable = [
        'country_id',
        'category_id',
        'alias',
        'email',
        'phone',
        'link',
        'fb',
        'twitter',
        'google',
        'youtube',
        'linkedin',
        'vimeo'
    ];

    protected $table = 'commercials';

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function getCover()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->cover);
    }

    public function ml()
    {
        return $this->hasMany(CommercialMl::class, 'id', 'id');
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