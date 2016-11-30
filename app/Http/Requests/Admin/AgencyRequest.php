<?php

namespace App\Http\Requests\Admin;

use App\Models\Agency\Agency;
use Route;
use Auth;

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
            'cover' => 'core_image',
            'email' => 'email|max:255|unique:agencies,email'.$agencyId.'|unique:adm_users,email|unique:brands,email|unique:creatives,email',
            'password' => 'required_with:re_password|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required_with:password|same:password',
            'phone' => 'max:255',
            'link' => 'required|url|max:255',
            'top' => 'in:'.Agency::TOP.','.Agency::NOT_TOP,
            'blocked' => 'in:'.Agency::BLOCKED.','.Agency::NOT_BLOCKED,
            'fb' => 'url|max:255',
            'twitter' => 'url|max:255',
            'google' => 'url|max:255',
            'youtube' => 'url|max:255',
            'linkedin' => 'url|max:255',
            'vimeo' => 'url|max:255',
            'show_status' => 'required|in:'.Agency::STATUS_ACTIVE.','.Agency::STATUS_INACTIVE,
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.sub_title' => 'max:255',
            'ml.*.about' => 'max:65000',
        ];
    }
}