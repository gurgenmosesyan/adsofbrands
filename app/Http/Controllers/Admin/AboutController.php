<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\About\Manager;
use App\Models\About\About;
use App\Core\Language\Language;
use App\Http\Requests\Admin\AboutRequest;

class AboutController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function edit()
    {
        $about = About::get()->keyBy('lng_id');
        $languages = Language::all();

        return view('admin.about.edit')->with([
            'about' => $about,
            'languages' => $languages
        ]);
    }

    public function update(AboutRequest $request)
    {
        $this->manager->update($request->all());
        return $this->api('OK');
    }
}