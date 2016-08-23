<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialCreditPerson;
use Auth;

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
            'brands' => 'required|array',
            'brands.*.brand_id' => 'required|integer|exists:brands,id',
            'agencies' => 'required|array',
            'agencies.*.agency_id' => 'required|integer|exists:agencies,id',
            'tags' => 'array',
            'tags.*.tag' => 'required|max:255',
            'credits' => 'array',
        ];

        if (Auth::guard('brand')->check()) {
            unset($rules['brands']);
            unset($rules['brands.*.brand_id']);
        } else if (Auth::guard('agency')->check()) {
            unset($rules['agencies']);
            unset($rules['agencies.*.agency_id']);
        }

        $type = $this->get('type');
        if ($type == Commercial::TYPE_VIDEO) {
            $rules['video_type'] = 'required|in:'.Commercial::VIDEO_TYPE_YOUTUBE.','.Commercial::VIDEO_TYPE_VIMEO.','.Commercial::VIDEO_TYPE_FB.','.Commercial::VIDEO_TYPE_EMBED;
            $videoType = $this->get('video_type');
            if ($videoType == Commercial::VIDEO_TYPE_YOUTUBE) {
                $rules['youtube_url'] = 'required|max:255';
                $rules['youtube_id'] = 'required|min:11|max:11';
            } else if ($videoType == Commercial::VIDEO_TYPE_VIMEO) {
                $rules['vimeo_url'] = 'required|max:255';
                $rules['vimeo_id'] = 'required|min:6|max:11';
            } else if ($videoType == Commercial::VIDEO_TYPE_FB) {
                $rules['fb_video_id'] = 'required|max:100';
            } else if ($videoType == Commercial::VIDEO_TYPE_EMBED) {
                $rules['embed_code'] = 'required|max:65000';
            }
        } else if ($type == Commercial::TYPE_PRINT) {
            $rules['image_print'] = 'required|core_image';
        }

        $advertisings = $this->get('advertisings');
        if (is_array($advertisings) && !empty($advertisings)) {
            $rules['advertising'] = 'required|max:255';
            foreach ($advertisings as $key => $value) {
                $rules['advertisings.'.$key.'.name'] = 'required|max:255';
                $rules['advertisings.'.$key.'.link'] = 'required|max:255';
            }
        }

        $credits = $this->get('credits');
        if (is_array($credits)) {
            foreach ($credits as $key => $credit) {
                $rules['credits.'.$key.'.id'] = 'integer|exists:commercial_credits,id';
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