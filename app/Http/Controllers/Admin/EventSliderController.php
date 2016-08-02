<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Facility\Facility;
use App\Models\Slider\Slider;
use App\Models\Slider\Manager;
use App\Models\Slider\Search;
use App\Http\Requests\Admin\SliderRequest;

class EventSliderController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.slider.index')->with(['key' => Slider::KEY_EVENTS]);
    }

    public function index(Search $search)
    {
        $search->key = Slider::KEY_EVENTS;
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $slider = new Slider();
        $facilities = Facility::joinMl()->get();
        return view('admin.slider.edit')->with([
            'slider' => $slider,
            'facilities' => $facilities,
            'key' => Slider::KEY_EVENTS,
            'saveMode' => 'add'
        ]);
    }

    public function store(SliderRequest $request)
    {
        $data = $request->all();
        $data['key'] = Slider::KEY_EVENTS;
        $this->manager->store($data);
        return $this->api('OK');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $facilities = Facility::joinMl()->get();
        return view('admin.slider.edit')->with([
            'slider' => $slider,
            'facilities' => $facilities,
            'key' => Slider::KEY_EVENTS,
            'saveMode' => 'edit'
        ]);
    }

    public function update(SliderRequest $request, $id)
    {
        $data = $request->all();
        $data['key'] = Slider::KEY_EVENTS;
        $this->manager->update($id, $data);
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }
}