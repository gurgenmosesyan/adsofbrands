<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Homepage\Manager;
use App\Models\Homepage\Homepage;
use App\Core\Language\Language;
use App\Models\Homepage\HomepageMl;
use App\Http\Requests\Admin\HomepageRequest;

class HomepageController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function edit()
    {
        $homepage = Homepage::first();
        $ml = HomepageMl::get()->keyBy('lng_id');
        $languages = Language::all();

        return view('admin.homepage.edit')->with([
            'homepage' => $homepage,
            'ml' => $ml,
            'languages' => $languages
        ]);
    }

    public function update(HomepageRequest $request)
    {
        $this->manager->update($request->all());
        return $this->api('OK');
    }
}