<?php

namespace App\Models\Creative;

use App\Core\Model;
use App\Models\Award\Award;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Creative extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const IMAGES_PATH = 'images/creative';
    const TYPE_PERSONAL = 'personal';
    const TYPE_BRAND = 'brand';
    const TYPE_AGENCY = 'agency';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const ACTIVE = '1';
    const NOT_ACTIVE = '0';
    const NOT_BLOCKED = '0';
    const BLOCKED = '1';

    public $adminInfo = true;

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
        'vimeo',
        'active',
        'blocked',
        'show_status'
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

    public function getImage()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function getCover()
    {
        return url('/'.self::IMAGES_PATH.'/'.$this->cover);
    }

    public function getLink()
    {
        return url_with_lng('/creative/'.$this->alias.'/'.$this->id);
    }

    public function awards()
    {
        return $this->hasMany(Award::class, 'type_id', 'id')->where('type', Award::TYPE_CREATIVE);
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