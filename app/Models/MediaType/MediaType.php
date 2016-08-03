<?php

namespace App\Models\MediaType;

use App\Core\Model;

class MediaType extends Model
{
    const IMAGES_PATH = 'images/media_type';

    protected $fillable = [];

    protected $table = 'media_types';

    public function getIcon()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->icon);
    }

    public function ml()
    {
        return $this->hasMany(MediaTypeMl::class, 'id', 'id');
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