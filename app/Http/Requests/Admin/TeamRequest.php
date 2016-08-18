<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class TeamRequest extends Request
{
    public function rules()
    {
        return [
            'image' => 'required|core_image',
            'sort_order' => 'integer',
            'ml' => 'ml',
            'ml.*.first_name' => 'required|max:255',
            'ml.*.last_name' => 'required|max:255',
            'ml.*.position' => 'required|max:255'
        ];
    }
}