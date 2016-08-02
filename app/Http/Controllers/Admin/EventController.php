<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Event\Event;
use App\Models\Event\Manager;
use App\Models\Event\EventText;
use App\Models\Event\Search;
use App\Http\Requests\Admin\EventRequest;
use App\Core\Language\Language;
use App\Http\Requests\Admin\EventTextRequest;

class EventController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.event.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $event = new Event();
        $languages = Language::all();
        return view('admin.event.edit')->with([
            'event' => $event,
            'languages' => $languages,
            'images' => [],
            'saveMode' => 'add'
        ]);
    }

    public function store(EventRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $languages = Language::all();
        return view('admin.event.edit')->with([
            'event' => $event,
            'languages' => $languages,
            'images' => $event->images,
            'saveMode' => 'edit'
        ]);
    }

    public function update(EventRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }

    public function text()
    {
        $texts = EventText::get()->keyBy('lng_id');
        $languages = Language::all();

        return view('admin.event.text')->with([
            'texts' => $texts,
            'languages' => $languages
        ]);
    }

    public function updateText(EventTextRequest $request)
    {
        $this->manager->updateText($request->all());
        return $this->api('OK');
    }
}