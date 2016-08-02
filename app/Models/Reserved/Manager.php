<?php

namespace App\Models\Reserved;

class Manager
{
    public function store($data)
    {
        $reserved = new Reserved($data);
        $reserved->type = Reserved::TYPE_ADMIN;
        $reserved->save();
    }

    public function update($id, $data)
    {
        $reserved = Reserved::findOrFail($id);
        $reserved->update($data);
    }

    public function delete($id)
    {
        Reserved::where('id', $id)->delete();
    }
}