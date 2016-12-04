<?php

namespace App\Models\Award;

use App\Models\Notification\Notification;
use Auth;
use DB;

class AwardManager
{
    public function store($data)
    {
        $award = new Award($data);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $award->type = Award::TYPE_BRAND;
            $award->type_id = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $award->type = Award::TYPE_AGENCY;
            $award->type_id = $agency->id;
        } else if (Auth::guard('creative')->check()) {
            $creative = Auth::guard('creative')->user();
            $award->type = Award::TYPE_CREATIVE;
            $award->type_id = $creative->id;
        }

        DB::transaction(function() use($data, $award) {
            $award->save();
            $this->storeMl($data['ml'], $award);
        });

        $notification = new Notification();
        $notification->send(route('admin_award_edit', $award->id), 'award');
    }

    public function update($id, $data)
    {
        $query = Award::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Award::TYPE_BRAND)->where('type_id', $brand->id);
            $data['type'] = Award::TYPE_BRAND;
            $data['type_id'] = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Award::TYPE_AGENCY)->where('type_id', $agency->id);
            $data['type'] = Award::TYPE_AGENCY;
            $data['type_id'] = $agency->id;
        } else if (Auth::guard('creative')->check()) {
            $creative = Auth::guard('creative')->user();
            $query->where('type', Award::TYPE_CREATIVE)->where('type_id', $creative->id);
            $data['type'] = Award::TYPE_CREATIVE;
            $data['type_id'] = $creative->id;
        }
        $award = $query->firstOrFail();

        DB::transaction(function() use($data, $award) {
            $award->update($data);
            $this->updateMl($data['ml'], $award);
        });
    }

    protected function storeMl($data, Award $award)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new AwardMl($mlData);
        }
        $award->ml()->saveMany($ml);
    }

    protected function updateMl($data, Award $award)
    {
        AwardMl::where('id', $award->id)->delete();
        $this->storeMl($data, $award);
    }

    public function delete($id)
    {
        $query = Award::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Award::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Award::TYPE_AGENCY)->where('type_id', $agency->id);
        } else if (Auth::guard('creative')->check()) {
            $creative = Auth::guard('creative')->user();
            $query->where('type', Award::TYPE_CREATIVE)->where('type_id', $creative->id);
        }
        $award = $query->firstOrFail();

        DB::transaction(function() use($award) {
            $award->delete();
            AwardMl::where('id', $award->id)->delete();
        });
    }
}