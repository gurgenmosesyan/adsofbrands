<?php

namespace App\Models\Brand;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Brand extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const IMAGES_PATH = 'images/brand';
    const REG_TYPE_ADMIN = 'admin';
    const REG_TYPE_REGISTERED = 'registered';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const TOP = '1';
    const NOT_TOP = '0';
    const ACTIVE = '1';
    const NOT_ACTIVE = '0';

    protected $fillable = [
        'country_id',
        'category_id',
        'alias',
        'email',
        'password',
        'phone',
        'link',
        'top',
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

    protected $table = 'brands';

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function getCover()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->cover);
    }

    public function isTop()
    {
        return $this->top == self::TOP;
    }

    public function ml()
    {
        return $this->hasMany(BrandMl::class, 'id', 'id');
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