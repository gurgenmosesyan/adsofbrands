<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\MediaType\MediaType;
use App\Models\MediaType\MediaTypeManager;
use App\Models\MediaType\MediaTypeSearch;
use App\Http\Requests\Admin\MediaTypeRequest;
use App\Core\Language\Language;

class MediaTypeController extends BaseController
{
    protected $manager = null;

    public function __construct(MediaTypeManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.media_type.index');
    }

    public function index(MediaTypeSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $mediaType = new MediaType();
        $languages = Language::all();

        return view('admin.media_type.edit')->with([
            'mediaType' => $mediaType,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(MediaTypeRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $mediaType = MediaType::where('id', $id)->firstOrFail();
        $languages = Language::all();

        return view('admin.media_type.edit')->with([
            'mediaType' => $mediaType,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(MediaTypeRequest $request, $id)
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