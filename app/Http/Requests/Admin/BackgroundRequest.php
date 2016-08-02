<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class BackgroundRequest extends Request
{
    public function rules()
    {
        return [
            'homepage' => 'required|core_image',
            'about' => 'core_image',
            'accommodation' => 'core_image',
            'offer' => 'core_image',
            'facility' => 'core_image',
            'event' => 'core_image'
        ];
    }
}