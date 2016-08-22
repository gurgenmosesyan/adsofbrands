<?php

namespace App\Models\Creative;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Creative extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const IMAGES_PATH = 'images/creative';
    const TYPE_PERSONAL = 'personal';
    const TYPE_BRAND = 'brand';
    const TYPE_AGENCY = 'agency';
    const REG_TYPE_ADMIN = 'admin';
    const REG_TYPE_REGISTERED = 'registered';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';

    protected $fillable = [
        'type',
        'type_id',
        'alias',
        'email',
        'phone',
        'link',
        'fb',
        'twitter',
        'google',
        'youtube',
        'linkedin',
        'vimeo'
    ];

    protected $table = 'creatives';

    public function isPersonal()
    {
        return $this->type == self::TYPE_PERSONAL;
    }

    public function isBrand()
    {
        return $this->type == self::TYPE_BRAND;
    }

    public function isAgency()
    {
        return $this->type == self::TYPE_AGENCY;
    }

    public function ml()
    {
        return $this->hasMany(CreativeMl::class, 'id', 'id');
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