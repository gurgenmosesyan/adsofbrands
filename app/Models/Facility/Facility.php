<?php

namespace App\Models\Facility;

use App\Core\Model;

class Facility extends Model
{
    const IMAGES_PATH = 'images/facility';

    protected $fillable = [
        'sort_order'
    ];

    protected $table = 'facilities';

    public function scopeJoinMl($query)
    {
        return $query->join('facilities_ml as ml', function($query) {
            $query->on('ml.id', '=', 'facilities.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('facilities.sort_order', 'asc');
    }

    public function ml()
    {
        return $this->hasMany(FacilityMl::class, 'id', 'id');
    }

    public function images()
    {
        return $this->hasMany(FacilityImage::class, 'facility_id', 'id')->active();
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