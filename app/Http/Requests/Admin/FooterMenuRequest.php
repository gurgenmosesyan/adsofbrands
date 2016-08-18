<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class FooterMenuRequest extends Request
{
    public function rules()
    {
        return [
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.text' => 'required|max:65000'
        ];
    }
}