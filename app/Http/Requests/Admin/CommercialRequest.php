<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialCreditPerson;

class CommercialRequest extends Request
{
    public function rules()
    {
        $rules = [
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
            //'image' => 'required|core_image',
            'views_count' => 'integer',
            'rating' => 'numeric',
            'qt' => 'integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.description' => 'required|max:2000',
            'tags' => 'array',
            'tags.*.tag' => 'required|max:255',
            'credits' => 'array',
        ];

        $credits = $this->get('credits');
        if (is_array($credits)) {
            foreach ($credits as $key => $credit) {
                $rules['credits.'.$key.'.position'] = 'required|max:255';
                $rules['credits.'.$key.'.sort_order'] = 'integer';
                $rules['credits.'.$key.'.persons'] = 'required|array';
                if (is_array($credit['persons'])) {
                    foreach ($credit['persons'] as $subKey => $person) {
                        $rules['credits.'.$key.'.persons.'.$subKey.'.type'] = 'required|in:'.CommercialCreditPerson::TYPE_CREATIVE.','.CommercialCreditPerson::TYPE_BRAND.','.CommercialCreditPerson::TYPE_AGENCY;
                        if (!empty($person['name']) && mb_substr($person['name'], 0, 1) == '@') {
                            $rules['credits.'.$key.'.persons.'.$subKey.'.type_id'] = 'required|integer';
                        } else {
                            $rules['credits.'.$key.'.persons.'.$subKey.'.type_id'] = 'integer';
                        }
                        $rules['credits.'.$key.'.persons.'.$subKey.'.name'] = 'required|max:255';
                        $rules['credits.'.$key.'.persons.'.$subKey.'.separator'] = 'required|max:1';
                    }
                }
            }
        }
        return $rules;
    }
}