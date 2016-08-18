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
            $this->updateBrands($data['brands'], $commercial);
            $this->updateAgencies($data['agencies'], $commercial);
            $this->updateTags($data['tags'], $commercial);
            $this->updateAdvertising($data['advertisings'], $commercial);
            $this->storeCredits($data['credits'], $commercial);
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
            $this->updateBrands($data['brands'], $commercial, true);
            $this->updateAgencies($data['agencies'], $commercial, true);
            $this->updateTags($data['tags'], $commercial, true);
            $this->updateAdvertising($data['advertisings'], $commercial, true);
            $this->updateCredits($data['credits'], $commercial, true);
        });
    }

    protected function processSave($data)
    {
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
            /*$credit['position'] = addslashes($credit['position']);
            $sql = "INSERT INTO `commercial_creative` (`commercial_id`, `position`) VALUES ( {$commercialId}, '{$credit['position']}' ) ";
            Yii::app()->db->createCommand($sql)->execute();
            $com_cr_id = Yii::app()->db->getLastInsertID();
            $com_cr_id = intval($com_cr_id);*/

            $persons = [];
            foreach ($value['persons'] as $person) {

                if (mb_substr($person['name'], 0, 1) == '@') {
                    $person['name'] = '';
                } else {
                    $person['type_id'] = 0;
                }
                $persons[] = new CommercialCreditPerson($person);

                /*$person['creative_id'] = intval($person['creative_id']);
                $person['creative_name'] = addslashes($person['creative_name']);
                $person['creative_separator'] = empty($person['creative_separator']) ? ',' : addslashes($person['creative_separator']);
                $sql = "REPLACE INTO `commercial_creative_rel` (`com_cr_id`, `creative_id`, `creative_name`, `creative_separator`, `sort_order`) VALUES ( {$com_cr_id}, {$person['creative_id']}, '{$person['creative_name']}', '{$person['creative_separator']}', {$i} ) ";
                Yii::app()->db->createCommand($sql)->execute();*/
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
            //$i = 1;
            if (!empty($value['id'])) {

                //if (isset($oldCredits[$value['id']])) {

                    unset($oldCredits[$value['id']]);

                    $value['commercial_id'] = $commercial->id;
                    $credit = CommercialCredit::where('id', $value['id'])->firstOrFail();
                    $credit->update($value);

                    /*$sql = "UPDATE `commercial_creative` SET `position` = '{$value['position']}' WHERE `id` = {$value['id']} ";
                    Yii::app()->db->createCommand($sql)->execute();*/

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

                    /*$sql = "DELETE FROM `commercial_creative_rel` WHERE `com_cr_id` = {$value['id']} ";
                    Yii::app()->db->createCommand($sql)->execute();*/
                    /*$insertStr = '';
                    foreach ($value['creatives'] AS $creativeRel) {
                        $insertStr .= "( {$creative['id']}, {$creativeRel['creative_id']}, '{$creativeRel['creative_name']}', '{$creativeRel['creative_separator']}', {$i} ),";
                        $i++;
                    }
                    $insertStr = rtrim($insertStr, ",");*/

                    /*$sql = "INSERT INTO `commercial_creative_rel` (`com_cr_id`, `creative_id`, `creative_name`, `creative_separator`, `sort_order`) VALUES {$insertStr} ";
                    Yii::app()->db->createCommand($sql)->execute();*/

                    unset($data[$key]);

                //}
            }
        }

        if (!$oldCredits->isEmpty()) {
            $deleteIds = $oldCredits->lists('id');
            CommercialCredit::whereIn('id', $deleteIds)->delete();
            CommercialCreditPerson::whereIn('credit_id', $deleteIds)->delete();

            /*$sql = "DELETE FROM `commercial_creative` WHERE `id` IN ( {$skipIdsStr} ) ";
            Yii::app()->db->createCommand($sql)->execute();
            $sql = "DELETE FROM `commercial_creative_rel` WHERE `com_cr_id` IN ( {$skipIdsStr} ) ";
            Yii::app()->db->createCommand($sql)->execute();*/
        }

        if (!empty($data)) {
            $this->storeCredits($data, $commercial);
        }
    }

    /*protected function updateCredits($data, Commercial $commercial, $editMode = false)
    {
        if ($editMode) {
            $creditIds = CommercialCredit::where('commercial_id', $commercial->id)->lists('id')->toArray();
            CommercialCreditPerson::whereIn('credit_id', $creditIds)->delete();
            if (empty($data)) {
                CommercialCredit::where('commercial_id', $commercial->id)->delete();
            }
        }
        $credits = [];
        if (empty($data)) {

        }
        //$maxId = CommercialCredit::select(DB::raw('MAX(id) as id'))->where('commercial_id', $commercial->id)->first();
        foreach ($data as $key => $value) {
            if (!empty($value['id'])) {

            }
            $credits[] = new CommercialCredit([
                'commercial_id' => $commercial->id,
                'position' => $value['position'],
                'sort_order' => $value['sort_order']
            ]);
            foreach ($value['persons'] as $person) {

            }
        }
    }*/

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Commercial::where('id', $id)->delete();
            CommercialMl::where('id', $id)->delete();
            $creditIds = CommercialCredit::where('commercial_id', $id)->lists('id')->toArray();
            CommercialCredit::where('commercial_id', $id)->delete();
            CommercialCreditPerson::whereIn('credit_id', $creditIds)->delete();
        });
    }
}