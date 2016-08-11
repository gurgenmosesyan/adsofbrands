<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Award\Award;

class AwardRequest extends Request
{
    public function rules()
    {
        $rules = [
            'type' => 'required|in:'.Award::TYPE_BRAND.','.Award::TYPE_AGENCY.','.Award::TYPE_CREATIVE,
            'year' => 'required|integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.category' => 'required|max:1000'
        ];

        $type = $this->get('type');
        if (!empty($type)) {
            if ($type == Award::TYPE_BRAND) {
                $rules['type_id'] = 'required|exists:brands,id';
            } else if ($type == Award::TYPE_AGENCY) {
                $rules['type_id'] = 'required|exists:agencies,id';
            } else if ($type == Award::TYPE_CREATIVE) {
                $rules['type_id'] = 'required|exists:creatives,id';
            }
        }

        return $rules;
    }
}