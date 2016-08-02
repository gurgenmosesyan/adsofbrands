<?php

namespace App\Models\Background;

use App\Core\Model;

class Background extends Model
{
    const IMAGES_PATH = 'images/background';

    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'backgrounds';

    public function getImage($key)
    {
        return url(self::IMAGES_PATH.'/'.$this->$key);
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