<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\AgencyMl;
use App\Models\Branch\Branch;
use App\Models\Branch\BranchManager;
use App\Models\Branch\BranchSearch;
use App\Http\Requests\Admin\BranchRequest;
use App\Core\Language\Language;
use App\Models\Brand\BrandMl;

class BranchController extends BaseController
{
    protected $manager = null;

    public function __construct(BranchManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.branch.index');
    }

    public function index(BranchSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $branch = new Branch();
        $languages = Language::all();

        return view('admin.branch.edit')->with([
            'branch' => $branch,
            'languages' => $languages,
            'typeName' => '',
            'saveMode' => 'add'
        ]);
    }

    public function store(BranchRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $branch = Branch::where('id', $id)->firstOrFail();
        $languages = Language::all();

        if ($branch->isBrand()) {
            $type = BrandMl::current()->where('id', $branch->type_id)->first();
        } else {
            $type = AgencyMl::current()->where('id', $branch->type_id)->first();
        }
        $typeName = $type == null ? '' : $type->title;

        return view('admin.branch.edit')->with([
            'branch' => $branch,
            'languages' => $languages,
            'typeName' => $typeName,
            'saveMode' => 'edit'
        ]);
    }

    public function update(BranchRequest $request, $id)
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