<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Creative\Creative;

class CreativeRequest extends Request
{
    public function rules()
    {
        $rules = [
            'type' => 'required|in:'.Creative::TYPE_PERSONAL.','.Creative::TYPE_BRAND.','.Creative::TYPE_AGENCY,
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255'
        ];

        $type = $this->get('type');
        if (!empty($type)) {
            if ($type == Creative::TYPE_BRAND) {
                $rules['type_id'] = 'required|exists:brands,id';
            } else if ($type == Creative::TYPE_AGENCY) {
                $rules['type_id'] = 'required|exists:agencies,id';
            }
        }

        return $rules;
    }
}