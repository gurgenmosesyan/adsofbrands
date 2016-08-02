<?php

namespace App\Models\Facility;

use App\Core\Model;

class FacilityImage extends Model
{
    const IMAGES_PATH = 'images/facility';

    protected $table = 'facility_images';

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