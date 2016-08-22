<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Creative\Creative;
use Route;

class CreativeRequest extends Request
{
    public function rules()
    {
        $creativeId = '';
        $params = Route::getCurrentRoute()->parameters();
        if (isset($params['id'])) {
            $creativeId = ','.$params['id'];
        }

        $rules = [
            'type' => 'required|in:'.Creative::TYPE_PERSONAL.','.Creative::TYPE_BRAND.','.Creative::TYPE_AGENCY,
            'alias' => 'required|max:255',
            'image' => 'required|core_image',
            'cover' => 'required|core_image',
            'email' => 'email|max:255|unique:creatives,email'.$creativeId.'|unique:adm_users,email|unique:brands,email|unique:agencies,email',
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
            'ml.*.about' => 'max:65000',
        ];

        $type = $this->get('type');
        if (!empty($type)) {
            if ($type == Creative::TYPE_BRAND) {
                $rules['type_id'] = 'required|exists:brands,id';
            } else if ($type == Creative::TYPE_AGENCY) {
                $rules['type_id'] = 'required|exists:agencies,id';
            }
        }

        return $rules;
    }
}