<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\AgencyMl;
use App\Models\Award\Award;
use App\Models\Award\AwardManager;
use App\Models\Award\AwardSearch;
use App\Http\Requests\Admin\AwardRequest;
use App\Core\Language\Language;
use App\Models\Brand\BrandMl;
use App\Models\Creative\CreativeMl;

class AwardController extends BaseController
{
    protected $manager = null;

    public function __construct(AwardManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.award.index');
    }

    public function index(AwardSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $award = new Award();
        $languages = Language::all();

        return view('admin.award.edit')->with([
            'award' => $award,
            'languages' => $languages,
            'typeName' => '',
            'saveMode' => 'add'
        ]);
    }

    public function store(AwardRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $award = Award::where('id', $id)->firstOrFail();
        $languages = Language::all();

        if ($award->isBrand()) {
            $type = BrandMl::current()->where('id', $award->type_id)->first();
            $typeName = $type == null ? '' : $type->title;
        } else if ($award->isAgency()) {
            $type = AgencyMl::current()->where('id', $award->type_id)->first();
            $typeName = $type == null ? '' : $type->title;
        } else {
            $type = CreativeMl::current()->where('id', $award->type_id)->first();
            $typeName = $type == null ? '' : $type->name;
        }

        return view('admin.award.edit')->with([
            'award' => $award,
            'languages' => $languages,
            'typeName' => $typeName,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AwardRequest $request, $id)
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