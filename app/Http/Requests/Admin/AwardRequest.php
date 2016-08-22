<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Award\Award;
use Auth;

class AwardRequest extends Request
{
    public function rules()
    {
        $rules = [
            'year' => 'required|integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.category' => 'required|max:1000'
        ];

        if (Auth::guard('admin')->check()) {
            $rules['type'] = 'required|in:'.Award::TYPE_BRAND.','.Award::TYPE_AGENCY.','.Award::TYPE_CREATIVE;
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
        }

        return $rules;
    }
}