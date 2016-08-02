<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Facility\Facility;
use App\Models\Slider\Slider;
use App\Models\Slider\Manager;
use App\Models\Slider\Search;
use App\Http\Requests\Admin\SliderRequest;

class SliderController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.slider.index');
    }

    public function index(Search $search)
    {
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
            'saveMode' => 'add'
        ]);
    }

    public function store(SliderRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $facilities = Facility::joinMl()->get();
        return view('admin.slider.edit')->with([
            'slider' => $slider,
            'facilities' => $facilities,
            'saveMode' => 'edit'
        ]);
    }

    public function update(SliderRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }
}