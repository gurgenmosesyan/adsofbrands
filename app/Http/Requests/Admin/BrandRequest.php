<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class BrandRequest extends Request
{
    public function rules()
    {
        return [
            'country_id' => 'integer|exists,countries,id',
            'category_id' => 'integer|exists,categories,id',
            'alias' => 'required|max:255',
            'image' => 'required|core_image',
            'cover' => 'required|core_image',
            'email' => 'email|max:255',
            'phone' => 'max:255',
            'link' => 'required|url|max:255',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.description' => 'max:10000',
            'ml.*.address' => 'max:255',
        ];
    }
}