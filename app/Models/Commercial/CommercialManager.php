<?php

namespace App\Models\Commercial;

use App\Core\Image\SaveImage;
use Auth;
use DB;

class CommercialManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $commercial = new Commercial($data);
        if (Auth::guard('admin')->guest()) {
            $commercial->featured = Commercial::NOT_FEATURED;
            $commercial->top = Commercial::NOT_TOP;
            $commercial->rating = 0;
            $commercial->qt = 0;
            $commercial->views_count = 0;
        }
        SaveImage::save($data['image'], $commercial);
        SaveImage::savePrintImage($data['image_print'], $commercial, 'image_print');

        DB::transaction(function() use($data, $commercial) {
            $commercial->save();
            $this->storeMl($data['ml'], $commercial);
            $this->updateBrands($data['brands'], $commercial);
            $this->updateAgencies($data['agencies'], $commercial);
            $this->updateTags($data['tags'], $commercial);
            $this->updateAdvertising($data['advertisings'], $commercial);
            if (empty($data['clone_id'])) {
                $this->storeCredits($data['credits'], $commercial);
            } else {
                $this->cloneCredits($data['clone_id'], $commercial);
            }
        });
    }

    public function update($id, $data)
    {
        $query = Commercial::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->join('commercial_brands as brands', function($query) use($brand) {
                $query->on('brands.commercial_id', '=', 'commercials.id')->where('brands.brand_id', '=', $brand->id);
            });
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->join('commercial_agencies as agencies', function($query) use($agency) {
                $query->on('agencies.commercial_id', '=', 'commercials.id')->where('agencies.agency_id', '=', $agency->id);
            });
        } else if (Auth::guard('creative')->check()) {
            $creative = Auth::guard('creative')->user();
            $commercialIds = CommercialCredit::join('commercial_credit_persons as person', function($query) use($creative) {
                $query->on('person.credit_id', '=', 'commercial_credits.id')->where('person.type', '=', CommercialCreditPerson::TYPE_CREATIVE)->where('type_id', '=', $creative->id);
            })->lists('commercial_credits.commercial_id')->toArray();
            $query->whereIn('id', $commercialIds);
        }
        $commercial = $query->firstOrFail();
        $data = $this->processSave($data);
        if (Auth::guard('admin')->guest()) {
            $data['featured'] = $commercial->featured;
            $data['top'] = $commercial->top;
            $data['rating'] = $commercial->rating;
            $data['qt'] = $commercial->qt;
            $data['views_count'] = $commercial->views_count;
        }
        SaveImage::save($data['image'], $commercial);
        SaveImage::savePrintImage($data['image_print'], $commercial, 'image_print');

        DB::transaction(function() use($data, $commercial) {
            $commercial->update($data);
            $this->updateMl($data['ml'], $commercial);
            $this->updateBrands($data['brands'], $commercial, true);
            $this->updateAgencies($data['agencies'], $commercial, true);
            $this->updateTags($data['tags'], $commercial, true);
            $this->updateAdvertising($data['advertisings'], $commercial, true);
            if (empty($data['clone_id'])) {
                $this->updateCredits($data['credits'], $commercial, true);
            } else {
                $this->cloneCredits($data['clone_id'], $commercial);
            }
        });
    }

    protected function processSave($data)
    {
        $data['brands'] = isset($data['brands']) ? $data['brands'] : [];
        $data['agencies'] = isset($data['agencies']) ? $data['agencies'] : [];

        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $data['brands'] = ['brand_id' => $brand->id];
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $data['agencies'] = ['agency_id' => $agency->id];
        }
        if ($data['type'] == Commercial::TYPE_VIDEO) {
            if ($data['video_type'] == Commercial::VIDEO_TYPE_YOUTUBE) {
                $data['video_data'] = json_encode(['id' => $data['youtube_id'], 'url' => $data['youtube_url']]);
            } else if ($data['video_type'] == Commercial::VIDEO_TYPE_VIMEO) {
                $data['video_data'] = json_encode(['id' => $data['vimeo_id'], 'url' => $data['vimeo_url']]);
            } else if ($data['video_type'] == Commercial::VIDEO_TYPE_FB) {
                $data['video_data'] = $data['fb_video_id'];
            } else {
                $data['video_data'] = $data['embed_code'];
            }
            $data['image_print'] = '';
        } else {
            $data['video_type'] = '';
            $data['video_data'] = '';
        }

        if (empty($data['month'])) {
            $data['published_date'] = '0000-00-00';
        } else {
            $data['published_date'] = date('Y-m-d', strtotime($data['year'].'-'.$data['month'].'-01'));
        }

        if (!isset($data['featured'])) {
            $data['featured'] = Commercial::NOT_FEATURED;
        }
        if (!isset($data['top'])) {
            $data['top'] = Commercial::NOT_TOP;
        }
        if (!isset($data['tags'])) {
            $data['tags'] = [];
        }
        if (!isset($data['advertisings'])) {
            $data['advertising'] = '';
            $data['advertisings'] = [];
        }
        if (!isset($data['credits'])) {
            $data['credits'] = [];
        }
        return $data;
    }

    protected function storeMl($data, Commercial $commercial)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new CommercialMl($mlData);
        }
        $commercial->ml()->saveMany($ml);
    }

    protected function updateMl($data, Commercial $commercial)
    {
        CommercialMl::where('id', $commercial->id)->delete();
        $this->storeMl($data, $commercial);
    }

    protected function updateBrands($data, Commercial $commercial, $editMode = false)
    {
        if ($editMode) {
            $commercial->brands()->detach();
        }
        $commercial->brands()->attach($data);
    }

    protected function updateAgencies($data, Commercial $commercial, $editMode = false)
    {
        if ($editMode) {
            $commercial->agencies()->detach();
        }
        $commercial->agencies()->attach($data);
    }

    protected function updateTags($data, Commercial $commercial, $editMode = false)
    {
        if ($editMode) {
            CommercialTag::where('commercial_id', $commercial->id)->delete();
        }
        $tags = [];
        foreach ($data as $value) {
            $tags[] = new CommercialTag($value);
        }
        if (!empty($tags)) {
            $commercial->tags()->saveMany($tags);
        }
    }

    protected function updateAdvertising($data, Commercial $commercial, $editMode = false)
    {
        if ($editMode) {
            CommercialAdvertising::where('commercial_id', $commercial->id)->delete();
        }
        $advertising = [];
        foreach ($data as $value) {
            $advertising[] = new CommercialAdvertising($value);
        }
        if (!empty($advertising)) {
            $commercial->advertisings()->saveMany($advertising);
        }
    }

    protected function storeCredits($credits, Commercial $commercial)
    {
        foreach ($credits as $value) {
            $value['commercial_id'] = $commercial->id;
            $credit = new CommercialCredit($value);
            $credit->save();

            $persons = [];
            foreach ($value['persons'] as $person) {

                if (mb_substr($person['name'], 0, 1) == '@') {
                    $person['name'] = '';
                } else {
                    $person['type_id'] = 0;
                }
                $persons[] = new CommercialCreditPerson($person);
            }
            $credit->persons()->saveMany($persons);
        }
    }

    protected function updateCredits($data, Commercial $commercial)
    {
        if (empty($data)) {
            $creditIds = CommercialCredit::where('commercial_id', $commercial->id)->lists('id')->toArray();
            CommercialCredit::where('commercial_id', $commercial->id)->delete();
            CommercialCreditPerson::whereIn('credit_id', $creditIds)->delete();
            return;
        }

        $oldCredits = $commercial->credits->keyBy('id');
        foreach ($data as $key => $value) {
            if (!empty($value['id'])) {

                unset($oldCredits[$value['id']]);

                $value['commercial_id'] = $commercial->id;
                $credit = CommercialCredit::where('id', $value['id'])->firstOrFail();
                $credit->update($value);

                CommercialCreditPerson::where('credit_id', $value['id'])->delete();

                $persons = [];
                foreach ($value['persons'] as $person) {
                    if (mb_substr($person['name'], 0, 1) == '@') {
                        $person['name'] = '';
                    } else {
                        $person['type_id'] = 0;
                    }
                    $persons[] = new CommercialCreditPerson($person);
                }
                $credit->persons()->saveMany($persons);

                unset($data[$key]);
            }
        }

        if (!$oldCredits->isEmpty()) {
            $deleteIds = $oldCredits->lists('id');
            CommercialCredit::whereIn('id', $deleteIds)->delete();
            CommercialCreditPerson::whereIn('credit_id', $deleteIds)->delete();
        }

        if (!empty($data)) {
            $this->storeCredits($data, $commercial);
        }
    }

    protected function cloneCredits($cloneId, Commercial $commercial)
    {
        if ($cloneId == $commercial->id) {
            return;
        }
        $creditIds = CommercialCredit::where('commercial_id', $commercial->id)->lists('id')->toArray();
        CommercialCredit::where('commercial_id', $commercial->id)->delete();
        CommercialCreditPerson::whereIn('credit_id', $creditIds)->delete();

        $credits = CommercialCredit::where('commercial_id', $cloneId)->with('persons')->get()->toArray();
        foreach ($credits as $value) {
            $credit = new CommercialCredit($value);
            $credit->commercial_id = $commercial->id;
            $credit->save();

            $persons = [];
            foreach ($value['persons'] as $person) {
                $persons[] = new CommercialCreditPerson($person);
            }
            $credit->persons()->saveMany($persons);
        }
    }

    public function delete($id)
    {
        $query = Commercial::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->join('commercial_brands as brands', function($query) use($brand) {
                $query->on('brands.commercial_id', '=', 'commercials.id')->where('brands.brand_id', '=', $brand->id);
            });
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->join('commercial_agencies as agencies', function($query) use($agency) {
                $query->on('agencies.commercial_id', '=', 'commercials.id')->where('agencies.agency_id', '=', $agency->id);
            });
        } else if (Auth::guard('creative')->check()) {
            $creative = Auth::guard('creative')->user();
            $commercialIds = CommercialCredit::join('commercial_credit_persons as person', function($query) use($creative) {
                $query->on('person.credit_id', '=', 'commercial_credits.id')->where('person.type', '=', CommercialCreditPerson::TYPE_CREATIVE)->where('type_id', '=', $creative->id);
            })->lists('commercial_credits.commercial_id')->toArray();
            $query->whereIn('id', $commercialIds);
        }
        $commercial = $query->firstOrFail();

        DB::transaction(function() use($commercial) {
            $commercial->delete();
            CommercialMl::where('id', $commercial->id)->delete();
            $creditIds = CommercialCredit::where('commercial_id', $commercial->id)->lists('id')->toArray();
            CommercialCredit::where('commercial_id', $commercial->id)->delete();
            CommercialCreditPerson::whereIn('credit_id', $creditIds)->delete();
        });
    }
}