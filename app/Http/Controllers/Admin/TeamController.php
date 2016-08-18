<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Team\Team;
use App\Models\Team\TeamManager;
use App\Models\Team\TeamSearch;
use App\Http\Requests\Admin\TeamRequest;
use App\Core\Language\Language;

class TeamController extends BaseController
{
    protected $manager = null;

    public function __construct(TeamManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.team.index');
    }

    public function index(TeamSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $team = new Team();
        $languages = Language::all();

        return view('admin.team.edit')->with([
            'team' => $team,
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(TeamRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $team = Team::where('id', $id)->firstOrFail();
        $languages = Language::all();

        return view('admin.team.edit')->with([
            'team' => $team,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(TeamRequest $request, $id)
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