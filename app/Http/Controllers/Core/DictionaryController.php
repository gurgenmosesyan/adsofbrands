<?php

namespace App\Http\Controllers\Core;

use App\Core\Dictionary\Manager;
use App\Core\Dictionary\Search;
use App\Http\Requests\Core\DictionaryRequest;
use App\Core\Language\Language;
use Illuminate\Http\Request;

class DictionaryController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table(Request $request)
    {
        $appId = $request->input('app') == '2' ? '2' : '1';
        $languages = Language::all();
        return view('core.dictionary.index')->with(['languages' => $languages, 'appId' => $appId]);
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function update(DictionaryRequest $request)
    {
        return $this->api('OK', $this->manager->update($request->all()));
    }

    public function delete(Request $request)
    {
        $key = $request->input('key');
        $appId = $request->input('app_id');
        return $this->api('OK', $this->manager->delete($key, $appId));
    }
}