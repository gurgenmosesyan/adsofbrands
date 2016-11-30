<?php

namespace App\Models\Agency;

use App\Core\Model;
use App\Models\Award\Award;
use App\Models\Branch\Branch;
use App\Models\Commercial\Commercial;
use App\Models\Creative\Creative;
use App\Models\News\News;
use App\Models\Vacancy\Vacancy;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Agency extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const IMAGES_PATH = 'images/agency';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const ACTIVE = '1';
    const NOT_ACTIVE = '0';
    const TOP = '1';
    const NOT_TOP = '0';
    const NOT_BLOCKED = '0';
    const BLOCKED = '1';

    public $adminInfo = true;

    protected $fillable = [
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
        'active',
        'blocked',
        'show_status'
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

    public function getLink()
    {
        return url_with_lng('/agencies/'.$this->alias.'/'.$this->id);
    }

    public function isTop()
    {
        return $this->top == self::TOP;
    }

    public function ml()
    {
        return $this->hasMany(AgencyMl::class, 'id', 'id');
    }

    public function commercials()
    {
        return $this->belongsToMany(Commercial::class, 'commercial_agencies', 'agency_id', 'commercial_id');
    }

    public function creatives()
    {
        return $this->hasMany(Creative::class, 'type_id', 'id')->where('type', Creative::TYPE_AGENCY);
    }

    public function awards()
    {
        return $this->hasMany(Award::class, 'type_id', 'id')->where('type', Award::TYPE_AGENCY);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'type_id', 'id')->where('type', Award::TYPE_AGENCY);
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_agencies', 'agency_id', 'news_id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'type_id', 'id')->where('type', Award::TYPE_AGENCY);
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