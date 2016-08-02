<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Background\Manager;
use App\Models\Background\Background;
use App\Http\Requests\Admin\BackgroundRequest;

class BackgroundController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function edit()
    {
        $background = Background::first();

        return view('admin.background.edit')->with([
            'background' => $background
        ]);
    }

    public function update(BackgroundRequest $request)
    {
        $this->manager->update($request->all());
        return $this->api('OK');
    }
}