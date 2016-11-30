<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\News\News;

class NewsRequest extends Request
{
    public function rules()
    {
        return [
            'alias' => 'required|max:255',
            'image' => 'required|core_image',
            'top' => 'in:'.News::NOT_TOP.','.News::TOP,
            'date' => 'date',
            'show_status' => 'required|in:'.News::STATUS_ACTIVE.','.News::STATUS_INACTIVE,
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.description' => 'required|max:2000',
            'ml.*.text' => 'required|max:65000',
            'brands' => 'array',
            'brands.*.brand_id' => 'required|integer|exists:brands,id',
            'agencies' => 'array',
            'agencies.*.agency_id' => 'required|integer|exists:agencies,id',
            'creatives' => 'array',
            'creatives.*.creative_id' => 'required|integer|exists:creatives,id',
            'tags' => 'array',
            'tags.*.tag' => 'required|max:255',
        ];
    }
}