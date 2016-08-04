<?php

namespace App\Models\Brand;

use App\Core\Model;

class Brand extends Model
{
    const IMAGES_PATH = 'images/brand';

    protected $fillable = [
        'country_id',
        'category_id',
        'alias',
        'email',
        'phone',
        'link'
    ];

    protected $table = 'brands';

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
        return $this->hasMany(BrandMl::class, 'id', 'id');
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