<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Commercial\Commercial;

class CommercialRequest extends Request
{
    public function rules()
    {
        return [
            'media_type_id' => 'required|integer|exists:media_types,id',
            'industry_type_id' => 'required|integer|exists:industry_types,id',
            'country_id' => 'integer|exists:countries,id',
            'category_id' => 'integer|exists:categories,id',
            'alias' => 'required|max:255',
            'type' => 'required|in:'.Commercial::TYPE_VIDEO.','.Commercial::TYPE_PRINT,
            'embed_code' => 'string|max:65000',
            'image_print' => 'core_image',
            'featured' => 'in:'.Commercial::NOT_FEATURED.','.Commercial::FEATURED,
            'top' => 'in:'.Commercial::NOT_TOP.','.Commercial::TOP,
            'published_date' => 'date',
            'image' => 'required|core_image',
            'views_count' => 'integer',
            'rating' => 'numeric',
            'qt' => 'integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.description' => 'required|max:2000',
            'tags' => 'array',
            'tags.*.tag' => 'required|max:255',
        ];
    }
}