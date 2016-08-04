<?php

namespace App\Models\Branch;

use DB;

class BranchManager
{
    public function store($data)
    {
        $branch = new Branch($data);

        DB::transaction(function() use($data, $branch) {
            $branch->save();
            $this->storeMl($data['ml'], $branch);
        });
    }

    public function update($id, $data)
    {
        $branch = Branch::where('id', $id)->firstOrFail();

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
        DB::transaction(function() use($id) {
            Branch::where('id', $id)->delete();
            BranchMl::where('id', $id)->delete();
        });
    }
}