<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Route;

class ShortLinkRequest extends Request
{
    public function rules()
    {
        $shortLinkId = '';
        $params = Route::getCurrentRoute()->parameters();
        if (isset($params['id'])) {
            $shortLinkId = ','.$params['id'];
        }

        return [
            'short_link' => 'required|url|max:255|unique:short_links,short_link'.$shortLinkId,
            'link' => 'required|url|max:255',
        ];
    }
}