<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\ShortLink\ShortLink;
use App\Models\ShortLink\ShortLinkManager;
use App\Models\ShortLink\ShortLinkSearch;
use App\Http\Requests\Admin\ShortLinkRequest;

class ShortLinkController extends BaseController
{
    protected $manager = null;

    public function __construct(ShortLinkManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.short_link.index');
    }

    public function index(ShortLinkSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $shortLink = new ShortLink();

        return view('admin.short_link.edit')->with([
            'shortLink' => $shortLink,
            'saveMode' => 'add'
        ]);
    }

    public function store(ShortLinkRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $shortLink = ShortLink::where('id', $id)->firstOrFail();

        return view('admin.short_link.edit')->with([
            'shortLink' => $shortLink,
            'saveMode' => 'edit'
        ]);
    }

    public function update(ShortLinkRequest $request, $id)
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