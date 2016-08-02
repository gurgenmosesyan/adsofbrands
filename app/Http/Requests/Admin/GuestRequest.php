<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class GuestRequest extends Request
{
    public function rules()
    {
        return [
            'image' => 'required|core_image',
            'ml' => 'ml',
            'ml.*.name' => 'required|max:255'
        ];
    }
}