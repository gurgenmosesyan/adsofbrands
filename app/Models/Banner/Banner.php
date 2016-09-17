<?php

namespace App\Models\Banner;

use App\Core\Model;

class Banner extends Model
{
    const IMAGES_PATH = 'images/cucataxtak';
    const KEY_HOMEPAGE_1 = '1';
    const KEY_HOMEPAGE_2 = '2';
    const KEY_HOMEPAGE_RIGHT = '3';
    const KEY_RIGHT_BLOCK = '4';

    const TYPE_IMAGE = 'image';
    const TYPE_EMBED = 'embed';

    protected $fillable = [
        'type',
        'embed'
    ];

    protected $table = 'banners';

    public function getBanner()
    {
        if ($this->type == self::TYPE_IMAGE) {
            return '<img src="'.url(self::IMAGES_PATH.'/'.$this->image).'" />';
        }
        return $this->embed;
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