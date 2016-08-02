<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Slider\Slider;

class SliderRequest extends Request
{
    public function rules()
    {
        return [
            'facility_id' => 'required|exists:facilities,id',
            'sort_order' => 'integer'
        ];
    }
}