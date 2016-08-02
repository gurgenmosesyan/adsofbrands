<?php

namespace App\Models\Slider;

class Manager
{
    public function store($data)
    {
        $slider = new Slider($data);
        $slider->save();
    }

    public function update($id, $data)
    {
        $slider = Slider::findOrFail($id);
        $slider->update($data);
    }

    public function delete($id)
    {
        Slider::where('id', $id)->delete();
    }
}