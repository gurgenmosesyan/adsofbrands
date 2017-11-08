<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Brand\Brand;
use Route;
use Auth;

class BrandRequest extends Request
{
    public function rules()
    {
        $brandId = '';
        $params = Route::getCurrentRoute()->parameters();
        if (isset($params['id'])) {
            $brandId = ','.$params['id'];
        }
        $statusReq = Auth::guard('admin')->check() ? 'required' : '';

        return [
            'country_id' => 'integer|exists:countries,id',
            'category_id' => 'integer|exists:categories,id',
            'alias' => 'required|max:255',
            'image' => 'required|core_image',
            'cover' => 'core_image',
            'email' => 'email|max:255|unique:brands,email'.$brandId.'|unique:adm_users,email|unique:agencies,email|unique:creatives,email',
            'password' => 'required_with:re_password|min:6|max:255|regex:/[a-z]{1,}[0-9]{1,}/i',
            're_password' => 'required_with:password|same:password',
            'phone' => 'max:255',
            'link' => 'required|url|max:255',
            'top' => 'in:'.Brand::NOT_TOP.','.Brand::TOP,
            'blocked' => 'in:'.Brand::BLOCKED.','.Brand::NOT_BLOCKED,
            'fb' => 'url|max:255',
            'twitter' => 'url|max:255',
            'google' => 'url|max:255',
            'youtube' => 'url|max:255',
            'linkedin' => 'url|max:255',
            'vimeo' => 'url|max:255',
            'instagram' => 'url|max:255',
            'pinterest' => 'url|max:255',
            'show_status' => $statusReq.'|in:'.Brand::STATUS_ACTIVE.','.Brand::STATUS_INACTIVE,
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.sub_title' => 'max:255',
            'ml.*.about' => 'max:65000',
        ];
    }
}