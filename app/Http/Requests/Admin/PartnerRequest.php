<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PartnerRequest extends Request
{
    public function rules()
    {
        return [
            'image' => 'required|core_image',
            'link' => 'max:255'
        ];
    }
}