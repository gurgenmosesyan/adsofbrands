<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class HomepageRequest extends Request
{
    public function rules()
    {
        return [
            'about_image' => 'required|core_image',
            'offers_image' => 'required|core_image',
            'ml' => 'ml',
            'ml.*.about_text' => 'required|max:65000',
            'ml.*.offers_text' => 'required|max:65000'
        ];
    }
}