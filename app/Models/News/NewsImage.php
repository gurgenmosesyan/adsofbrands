<?php

namespace App\Models\News;

use App\Core\Model;

class NewsImage extends Model
{
    const IMAGES_PATH = 'images/news';

    protected $table = 'news_images';

    public $timestamps = false;

    protected $fillable = [
        'news_id',
        'show_status'
    ];

    public function getImage()
    {
        return url(self::IMAGES_PATH.'/'.$this->image);
    }

    public function getFile($column)
    {
        return $this->{$column};
    }
    public function setFile($image, $column)
    {
        return $this->attributes[$column] = $image;
    }
    public function getStorePath()
    {
        return self::IMAGES_PATH;
    }
}