<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class FacilityRequest extends Request
{
    public function rules()
    {
        return [
            'sort_order' => 'integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.text' => 'required|max:65000',
            'images' => 'required|array',
            'images.*.id' => 'integer',
            'images.*.image' => 'required|core_image'
        ];
    }
}