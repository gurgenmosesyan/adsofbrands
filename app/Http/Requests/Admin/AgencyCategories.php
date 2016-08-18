<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AgencyCategoryRequest extends Request
{
    public function rules()
    {
        return [
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255'
        ];
    }
}