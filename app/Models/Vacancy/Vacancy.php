<?php

namespace App\Models\Vacancy;

use App\Core\Model;

class Vacancy extends Model
{
    const ASAP_YES = '1';
    const ASAP_NO = '0';

    protected $table = 'vacancies';

    protected $fillable = [
        'asap',
        'published_at',
        'start_date',
        'open_date',
        'deadline'
    ];

    public function scopeJoinMl($query)
    {
        return $query->join('vacancies_ml as ml', function($query) {
            $query->on('ml.id', '=', 'vacancies.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function setAsapAttribute($asap)
    {
        $this->attributes['asap'] = isset($asap) ? $asap : self::ASAP_NO;
    }

    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = empty($date) ? date('Y-m-d') : $date;
    }

    public function setStartDateAttribute($date)
    {
        $this->attributes['start_date'] = empty($date) ? date('Y-m-d') : $date;
    }

    public function setOpenDateAttribute($date)
    {
        $this->attributes['open_date'] = empty($date) ? date('Y-m-d') : $date;
    }

    public function setDeadlineAttribute($date)
    {
        $this->attributes['deadline'] = empty($date) ? '0000-00-00' : $date;
    }

    public function ml()
    {
        return $this->hasMany(VacancyMl::class, 'id', 'id');
    }
}