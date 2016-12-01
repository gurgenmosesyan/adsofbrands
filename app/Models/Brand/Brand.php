<?php

namespace App\Models\Brand;

use App\Core\Model;
use App\Models\Award\Award;
use App\Models\Branch\Branch;
use App\Models\Commercial\Commercial;
use App\Models\Creative\Creative;
use App\Models\News\News;
use App\Models\Vacancy\Vacancy;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Brand extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const IMAGES_PATH = 'images/brand';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const TOP = '1';
    const NOT_TOP = '0';
    const ACTIVE = '1';
    const NOT_ACTIVE = '0';
    const NOT_BLOCKED = '0';
    const BLOCKED = '1';

    public $adminInfo = true;

    protected $fillable = [
        'country_id',
        'category_id',
        'alias',
        'email',
        'phone',
        'link',
        'top',
        'fb',
        'twitter',
        'google',
        'youtube',
        'linkedin',
        'vimeo',
        'instagram',
        'pinterest',
        'active',
        'blocked',
        'show_status'
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

    public function getLink()
    {
        return url_with_lng('/brands/'.$this->alias.'/'.$this->id);
    }

    public function isTop()
    {
        return $this->top == self::TOP;
    }

    public function ml()
    {
        return $this->hasMany(BrandMl::class, 'id', 'id');
    }

    public function commercials()
    {
        return $this->belongsToMany(Commercial::class, 'commercial_brands', 'brand_id', 'commercial_id');
    }

    public function creatives()
    {
        return $this->hasMany(Creative::class, 'type_id', 'id')->where('type', Creative::TYPE_BRAND);
    }

    public function awards()
    {
        return $this->hasMany(Award::class, 'type_id', 'id')->where('type', Award::TYPE_BRAND);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'type_id', 'id')->where('type', Award::TYPE_BRAND);
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_brands', 'brand_id', 'news_id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'type_id', 'id')->where('type', Award::TYPE_BRAND);
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