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
use Auth;

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
        $query = Award::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Award::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Award::TYPE_AGENCY)->where('type_id', $agency->id);
        } else if (Auth::guard('creative')->check()) {
            $creative = Auth::guard('creative')->user();
            $query->where('type', Award::TYPE_CREATIVE)->where('type_id', $creative->id);
        }
        $award = $query->firstOrFail();
        $languages = Language::all();

        $typeName = '';
        if (Auth::guard('admin')->check()) {
            if ($award->isBrand()) {
                $type = BrandMl::current()->where('id', $award->type_id)->first();
            } else if ($award->isAgency()) {
                $type = AgencyMl::current()->where('id', $award->type_id)->first();
            } else {
                $type = CreativeMl::current()->where('id', $award->type_id)->first();
            }
            $typeName = $type == null ? '' : $type->title;
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