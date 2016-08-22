<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Route;

class BrandRequest extends Request
{
    public function rules()
    {
        $brandId = '';
        $params = Route::getCurrentRoute()->parameters();
        if (isset($params['id'])) {
            $brandId = ','.$params['id'];
        }

        return [
            'country_id' => 'integer|exists:countries,id',
            'category_id' => 'integer|exists:categories,id',
            'alias' => 'required|max:255',
            'image' => 'required|core_image',
            'cover' => 'required|core_image',
            'email' => 'email|max:255|unique:brands,email'.$brandId.'|unique:adm_users,email|unique:agencies,email|unique:creatives,email',
            'phone' => 'max:255',
            'link' => 'required|url|max:255',
            'fb' => 'url|max:255',
            'twitter' => 'url|max:255',
            'google' => 'url|max:255',
            'youtube' => 'url|max:255',
            'linkedin' => 'url|max:255',
            'vimeo' => 'url|max:255',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.sub_title' => 'required|max:255',
            'ml.*.about' => 'max:65000',
            'ml.*.address' => 'max:255',
        ];
    }
}