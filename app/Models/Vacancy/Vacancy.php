<?php

namespace App\Models\Vacancy;

use App\Core\Model;

class Vacancy extends Model
{
    const TYPE_BRAND = 'brand';
    const TYPE_AGENCY = 'agency';

    public $adminInfo = true;

    protected $fillable = [
        'type',
        'type_id'
    ];

    protected $table = 'vacancies';

    public function isBrand()
    {
        return $this->type == self::TYPE_BRAND;
    }

    public function ml()
    {
        return $this->hasMany(VacancyMl::class, 'id', 'id');
    }
}