<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Text\Text;
use App\Models\Text\Manager;
use App\Models\Text\Search;
use App\Http\Requests\Admin\TextRequest;
use App\Core\Language\Language;

class TextController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.text.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function edit($id)
    {
        $text = Text::findOrFail($id);
        $languages = Language::all();
        return view('admin.text.edit')->with([
            'text' => $text,
            'languages' => $languages
        ]);
    }

    public function update(TextRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }
}