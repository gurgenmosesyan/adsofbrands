<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class EventTextRequest extends Request
{
    public function rules()
    {
        return [
            'ml' => 'ml',
            'ml.*.text' => 'required|max:65000'
        ];
    }
}