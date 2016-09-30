<?php

namespace App\Models\Branch;

use Auth;
use DB;

class BranchManager
{
    public function store($data)
    {
        $branch = new Branch($data);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $branch->type = Branch::TYPE_BRAND;
            $branch->type_id = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $branch->type = Branch::TYPE_AGENCY;
            $branch->type_id = $agency->id;
        }

        DB::transaction(function() use($data, $branch) {
            $branch->save();
            $this->storeMl($data['ml'], $branch);
        });
    }

    public function update($id, $data)
    {
        $query = Branch::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Branch::TYPE_BRAND)->where('type_id', $brand->id);
            $data['type'] = Branch::TYPE_BRAND;
            $data['type_id'] = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Branch::TYPE_AGENCY)->where('type_id', $agency->id);
            $data['type'] = Branch::TYPE_AGENCY;
            $data['type_id'] = $agency->id;
        }
        $branch = $query->firstOrFail();

        DB::transaction(function() use($data, $branch) {
            $branch->update($data);
            $this->updateMl($data['ml'], $branch);
        });
    }

    protected function storeMl($data, Branch $branch)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new BranchMl($mlData);
        }
        $branch->ml()->saveMany($ml);
    }

    protected function updateMl($data, Branch $branch)
    {
        BranchMl::where('id', $branch->id)->delete();
        $this->storeMl($data, $branch);
    }

    public function delete($id)
    {
        $query = Branch::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Branch::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Branch::TYPE_AGENCY)->where('type_id', $agency->id);
        }
        $branch = $query->firstOrFail();

        DB::transaction(function() use($branch) {
            $branch->delete();
            BranchMl::where('id', $branch->id)->delete();
        });
    }
}