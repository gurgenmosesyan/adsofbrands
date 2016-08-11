<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\AgencyMl;
use App\Models\Creative\Creative;
use App\Models\Creative\CreativeManager;
use App\Models\Creative\CreativeSearch;
use App\Http\Requests\Admin\CreativeRequest;
use App\Core\Language\Language;
use App\Models\Brand\BrandMl;

class CreativeController extends BaseController
{
    protected $manager = null;

    public function __construct(CreativeManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.creative.index');
    }

    public function index(CreativeSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $creative = new Creative();
        $languages = Language::all();

        return view('admin.creative.edit')->with([
            'creative' => $creative,
            'languages' => $languages,
            'typeName' => '',
            'saveMode' => 'add'
        ]);
    }

    public function store(CreativeRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $creative = Creative::where('id', $id)->firstOrFail();
        $languages = Language::all();

        if ($creative->isBrand()) {
            $type = BrandMl::current()->where('id', $creative->type_id)->first();
        } else if ($creative->isAgency()) {
            $type = AgencyMl::current()->where('id', $creative->type_id)->first();
        }
        $typeName = $type == null ? '' : $type->title;

        return view('admin.creative.edit')->with([
            'creative' => $creative,
            'languages' => $languages,
            'typeName' => $typeName,
            'saveMode' => 'edit'
        ]);
    }

    public function update(CreativeRequest $request, $id)
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