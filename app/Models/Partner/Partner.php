<?php

namespace App\Models\Partner;

use App\Core\Model;

class Partner extends Model
{
    const IMAGES_PATH = 'images/partner';

    protected $table = 'partners';

    protected $fillable = [
        'link'
    ];

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
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