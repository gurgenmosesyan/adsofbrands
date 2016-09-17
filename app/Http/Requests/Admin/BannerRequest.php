<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Banner\Banner;

class BannerRequest extends Request
{
    public function rules()
    {
        return [
            'type' => 'required|in:'.Banner::TYPE_IMAGE.','.Banner::TYPE_EMBED,
            'image' => 'required_if:type,'.Banner::TYPE_IMAGE.'|core_image',
            'embed' => 'required_if:type,'.Banner::TYPE_EMBED.'|max:65000',
        ];
    }
}