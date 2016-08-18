<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AgencyRequest extends Request
{
    public function rules()
    {
        return [
            'alias' => 'required|max:255',
            'category_id' => 'integer|exists:agency_categories,id',
            'image' => 'required|core_image',
            'cover' => 'required|core_image',
            'email' => 'email|max:255',
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