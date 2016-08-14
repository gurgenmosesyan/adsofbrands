<?php

namespace App\Models\Commercial;

use App\Core\Image\SaveImage;
use DB;

class CommercialManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $commercial = new Commercial($data);
        SaveImage::save($data['image'], $commercial);
        SaveImage::save($data['image_print'], $commercial, 'image_print');

        DB::transaction(function() use($data, $commercial) {
            $commercial->save();
            $this->storeMl($data['ml'], $commercial);
            $this->updateTags($data['tags'], $commercial);
            $this->updateCredits($data['credits'], $commercial);
        });
    }

    public function update($id, $data)
    {
        $commercial = Commercial::where('id', $id)->firstOrFail();
        $data = $this->processSave($data);
        SaveImage::save($data['image'], $commercial);
        SaveImage::save($data['image_print'], $commercial, 'image_print');

        DB::transaction(function() use($data, $commercial) {
            $commercial->update($data);
            $this->updateMl($data['ml'], $commercial);
            $this->updateTags($data['tags'], $commercial, true);
            $this->updateCredits($data['credits'], $commercial, true);
        });
    }

    protected function processSave($data)
    {
        if (!isset($data['featured'])) {
            $data['featured'] = Commercial::NOT_FEATURED;
        }
        if (!isset($data['top'])) {
            $data['top'] = Commercial::NOT_TOP;
        }
        if (!isset($data['tags'])) {
            $data['tags'] = [];
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

    protected function updateCredits($data, Commercial $commercial, $editMode = false)
    {
        if ($editMode) {
            $creditIds = CommercialCredit::where('commercial_id')->lists('id')->toArray();
            CommercialCredit::where('commercial_id')->delete();
            CommercialCreditPerson::whereIn('credit_id', $creditIds)->delete();
        }
        $credits = [];
        if (!empty($data)) {
            $maxId = CommercialCredit::select(DB::raw('MAX(id) as id'))->where('commercial_id', $commercial->id)->first();
            if ($maxId == null) {
                $maxId = 1;
            } else {
                $maxId = $maxId->id + 1;
            }
            $i = $maxId;
            foreach ($data as $key => $value) {
                $credits[] = new CommercialCredit([
                    'id' => $i,
                    'commercial_id' => $commercial->id,
                    'position' => $value['position'],
                    'sort_order' => $value['sort_order']
                ]);
                foreach ($value['persons'] as $person) {

                }
            }
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Commercial::where('id', $id)->delete();
            CommercialMl::where('id', $id)->delete();
        });
    }
}