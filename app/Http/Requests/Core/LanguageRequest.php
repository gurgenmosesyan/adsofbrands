<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\Request;
use App\Core\Language\Language;

class LanguageRequest extends Request
{
    public function rules()
    {
        return [
            'code' => 'required|max:30',
            'name' => 'required',
            'icon' => 'core_image',
            'default' => 'in:'.Language::DEFAULT_LNG.','.Language::NOT_DEFAULT_LNG
        ];
    }
}