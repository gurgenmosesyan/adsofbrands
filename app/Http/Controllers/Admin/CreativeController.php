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
use Auth;

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
        if (Auth::guard('creative')->check()) {
            $user = Auth::guard('creative')->user();
            if ($user->id != $id) {
                abort(404);
            }
        }
        $query = Creative::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Creative::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Creative::TYPE_AGENCY)->where('type_id', $agency->id);
        }
        $creative = $query->firstOrFail();
        $languages = Language::all();

        $typeName = '';
        if (Auth::guard('admin')->check()) {
            if ($creative->isBrand()) {
                $type = BrandMl::current()->where('id', $creative->type_id)->first();
                $typeName = $type == null ? '' : $type->title;
            } else if ($creative->isAgency()) {
                $type = AgencyMl::current()->where('id', $creative->type_id)->first();
                $typeName = $type == null ? '' : $type->title;
            }
        }

        return view('admin.creative.edit')->with([
            'creative' => $creative,
            'languages' => $languages,
            'typeName' => $typeName,
            'saveMode' => 'edit'
        ]);
    }

    public function update(CreativeRequest $request, $id)
    {
        if (Auth::guard('creative')->check()) {
            $user = Auth::guard('creative')->user();
            if ($user->id != $id) {
                abort(404);
            }
        }
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }
}