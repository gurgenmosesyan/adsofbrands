<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Creative\Creative;
use Route;
use Auth;

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
            'alias' => 'required|max:255',
            'image' => 'required|core_image',
            'cover' => 'core_image',
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

        if (Auth::guard('admin')->check()) {
            $rules['type'] = 'required|in:'.Creative::TYPE_PERSONAL.','.Creative::TYPE_BRAND.','.Creative::TYPE_AGENCY;
            $type = $this->get('type');
            if (!empty($type)) {
                if ($type == Creative::TYPE_BRAND) {
                    $rules['type_id'] = 'required|exists:brands,id';
                } else if ($type == Creative::TYPE_AGENCY) {
                    $rules['type_id'] = 'required|exists:agencies,id';
                }
            }
        } else if (Auth::guard('creative')->check()) {
            $rules['password'] = 'required_with:re_password|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i';
            $rules['re_password'] = 'required_with:password|same:password';
        }

        return $rules;
    }
}