<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Vacancy\Vacancy;

class VacancyRequest extends Request
{
    public function rules()
    {
        return [
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.function' => 'required|max:255',
            'ml.*.term' => 'max:255',
            'ml.*.location' => 'max:255',
            'ml.*.description' => 'max:10000',
            'ml.*.responsibilities' => 'max:10000',
            'ml.*.qualifications' => 'max:10000',
            'ml.*.procedures' => 'max:10000',
            'ml.*.about' => 'max:10000',
            'asap' => 'in:'.Vacancy::ASAP_NO.','.Vacancy::ASAP_YES,
            'published_at' => 'date',
            'start_date' => 'date',
            'open_date' => 'date',
            'deadline' => 'date'
        ];
    }
}