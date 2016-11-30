<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\FooterMenu\FooterMenu;
use App\Models\FooterMenu\FooterMenuManager;
use App\Models\FooterMenu\FooterMenuSearch;
use App\Http\Requests\Admin\FooterMenuRequest;
use App\Core\Language\Language;

class FooterMenuController extends BaseController
{
    protected $manager = null;

    public function __construct(FooterMenuManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.footer_menu.index');
    }

    public function index(FooterMenuSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $menu = new FooterMenu();
        $menu->show_status = FooterMenu::STATUS_ACTIVE;
        $languages = Language::all();

        return view('admin.footer_menu.edit')->with([
            'menu' => $menu,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(FooterMenuRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $menu = FooterMenu::where('id', $id)->firstOrFail();
        $languages = Language::all();

        return view('admin.footer_menu.edit')->with([
            'menu' => $menu,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(FooterMenuRequest $request, $id)
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