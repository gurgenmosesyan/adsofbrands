<?php

namespace App\Http\Controllers;

use App\Models\Team\Team;

class TeamController extends Controller
{
    public function index()
    {
        $team = Team::joinMl()->ordered()->get();

        return view('team.index')->with([
            'team' => $team
        ]);
    }
}