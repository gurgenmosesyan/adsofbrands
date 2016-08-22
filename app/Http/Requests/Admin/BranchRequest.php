<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Branch\Branch;
use Auth;

class BranchRequest extends Request
{
    public function rules()
    {
        $rules = [
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.address' => 'required|max:255'
        ];

        if (Auth::guard('admin')->check()) {
            $rules['type'] = 'required|in:'.Branch::TYPE_BRAND.','.Branch::TYPE_AGENCY;
            $type = $this->get('type');
            if (!empty($type)) {
                if ($type == Branch::TYPE_BRAND) {
                    $rules['type_id'] = 'required|exists:brands,id';
                } else if ($type == Branch::TYPE_AGENCY) {
                    $rules['type_id'] = 'required|exists:agencies,id';
                }
            }
        }

        $lat  = $this->get('lat');
        $lng  = $this->get('lng');
        if (empty($lat) || empty($lng)) {
            $rules['location'] = 'required';
        }

        return $rules;
    }
}