<?php

namespace App\Models\Agency;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Agency extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const IMAGES_PATH = 'images/agency';
    const REG_TYPE_ADMIN = 'admin';
    const REG_TYPE_REGISTERED = 'registered';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const ACTIVE = '1';
    const NOT_ACTIVE = '0';

    protected $fillable = [
        'category_id',
        'alias',
        'email',
        'password',
        'phone',
        'link',
        'fb',
        'twitter',
        'google',
        'youtube',
        'linkedin',
        'vimeo',
        'rating',
        'qt',
        'active'
    ];

    protected $table = 'agencies';

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function getCover()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->cover);
    }

    public function ml()
    {
        return $this->hasMany(AgencyMl::class, 'id', 'id');
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