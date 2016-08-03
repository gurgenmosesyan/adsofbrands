<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class MediaTypeRequest extends Request
{
    public function rules()
    {
        return [
            'icon' => 'required|core_image',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255'
        ];
    }
}