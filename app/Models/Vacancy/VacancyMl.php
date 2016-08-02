<?php

namespace App\Models\Vacancy;

use App\Core\Model;

class VacancyMl extends Model
{
    protected $table = 'vacancies_ml';

    public $timestamps = false;

    protected $fillable = [
        'lng_id',
        'title',
        'function',
        'term',
        'location',
        'description',
        'responsibilities',
        'qualifications',
        'procedures',
        'about'
    ];
}