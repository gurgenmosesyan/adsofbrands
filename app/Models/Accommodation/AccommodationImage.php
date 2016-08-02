<?php

namespace App\Models\Accommodation;

use App\Core\Model;

class AccommodationImage extends Model
{
    const IMAGES_PATH = 'images/accommodation';

    protected $table = 'accommodation_images';

    public $timestamps = false;

    protected $fillable = [
        'show_status'
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