<?php

namespace App\Models\Team;

use App\Core\Model;

class Team extends Model
{
    const IMAGES_PATH = 'images/team';

    protected $fillable = [
        'link',
        'sort_order'
    ];

    protected $table = 'team';

    public function getIcon()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->icon);
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