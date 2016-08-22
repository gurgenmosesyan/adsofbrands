<?php

namespace App\Http\Requests\Admin;
use Route;

use App\Http\Requests\Request;

class AgencyRequest extends Request
{
    public function rules()
    {
        $agencyId = '';
        $params = Route::getCurrentRoute()->parameters();
        if (isset($params['id'])) {
            $agencyId = ','.$params['id'];
        }

        return [
            'alias' => 'required|max:255',
            'category_id' => 'integer|exists:agency_categories,id',
            'image' => 'required|core_image',
            'cover' => 'required|core_image',
            'email' => 'email|max:255|unique:agencies,email'.$agencyId.'|unique:adm_users,email|unique:brands,email|unique:creatives,email',
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