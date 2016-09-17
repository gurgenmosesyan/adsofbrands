<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Banner\Banner;
use App\Models\Banner\BannerManager;
use App\Models\Banner\BannerSearch;
use App\Http\Requests\Admin\BannerRequest;
use App\Core\Language\Language;

class BannerController extends BaseController
{
    protected $manager = null;

    public function __construct(BannerManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.banner.index');
    }

    public function index(BannerSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function edit($id)
    {
        $banner = Banner::where('id', $id)->firstOrFail();
        $languages = Language::all();

        return view('admin.banner.edit')->with([
            'banner' => $banner,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(BannerRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }
}