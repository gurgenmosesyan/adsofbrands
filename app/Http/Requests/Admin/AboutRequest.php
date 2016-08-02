<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AboutRequest extends Request
{
    public function rules()
    {
        return [
            'ml' => 'ml',
            'ml.*.text' => 'required|max:65000'
        ];
    }
}