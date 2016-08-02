<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Partner\Partner;
use App\Models\Partner\Manager;
use App\Models\Partner\Search;
use App\Http\Requests\Admin\PartnerRequest;

class PartnerController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.partner.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $partner = new Partner();
        return view('admin.partner.edit')->with([
            'partner' => $partner,
            'saveMode' => 'add'
        ]);
    }

    public function store(PartnerRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partner.edit')->with([
            'partner' => $partner,
            'saveMode' => 'edit'
        ]);
    }

    public function update(PartnerRequest $request, $id)
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