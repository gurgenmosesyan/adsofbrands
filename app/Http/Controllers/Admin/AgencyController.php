<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\Agency;
use App\Models\Agency\AgencyManager;
use App\Models\Agency\AgencySearch;
use App\Http\Requests\Admin\AgencyRequest;
use App\Models\AgencyCategory\Category;
use App\Core\Language\Language;
use Auth;

class AgencyController extends BaseController
{
    protected $manager = null;

    public function __construct(AgencyManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.agency.index');
    }

    public function index(AgencySearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $agency = new Agency();
        $agency->show_status = Agency::STATUS_ACTIVE;
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        return view('admin.agency.edit')->with([
            'agency' => $agency,
            'categories' => $categories,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(AgencyRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        if (Auth::guard('agency')->check()) {
            $user = Auth::guard('agency')->user();
            if ($user->id != $id) {
                abort(404);
            }
        }
        $agency = Agency::where('id', $id)->firstOrFail();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        return view('admin.agency.edit')->with([
            'agency' => $agency,
            'categories' => $categories,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AgencyRequest $request, $id)
    {
        if (Auth::guard('agency')->check()) {
            $user = Auth::guard('agency')->user();
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