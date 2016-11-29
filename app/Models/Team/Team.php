<?php

namespace App\Models\Team;

use App\Core\Model;

class Team extends Model
{
    const IMAGES_PATH = 'images/team';

    public $adminInfo = true;

    protected $fillable = [
        'link',
        'sort_order'
    ];

    protected $table = 'team';

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function ml()
    {
        return $this->hasMany(TeamMl::class, 'id', 'id');
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