<?php

namespace App\Core\Language;

use App\Core\Model;

class Language extends Model
{
    const DEFAULT_LNG = '1';
    const NOT_DEFAULT_LNG = '0';
    const IMAGES_PATH = 'images/language';

    protected $table = 'languages';

    protected $fillable = [
        'code',
        'name',
        //'icon',
        'default'
    ];

    public function scopeDefaultLng($query)
    {
        return $query->where('default', self::DEFAULT_LNG);
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