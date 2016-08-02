<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AccommodationRequest extends Request
{
    public function rules()
    {
        $rules = [
            'room_quantity' => 'required|integer',
            'price' => 'required|integer',
            'room_size' => 'required|numeric',
            'sort_order' => 'integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.text' => 'required|max:65000',
            'ml.*.bed_type' => 'required|max:255',
            'images' => 'required|array',
            'images.*.id' => 'integer',
            'images.*.image' => 'required|core_image',
            'ml.*.facilities' => 'string',
            'ml.*.facilities.*.title' => 'required|max:255',
            'details' => 'array',
            'details.*.price' => 'required|integer',
            'details.*.ml' => 'array|ml',
            'details.*.ml.*.title' => 'required|max:255'
        ];
        $details = $this->get('details');
        if (is_array($details)) {
            foreach ($details as $key => $value) {
                $rules['details.'.$key.'.ml'] = 'ml';
            }
        }
        return $rules;
    }
}