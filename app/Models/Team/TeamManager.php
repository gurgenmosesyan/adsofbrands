<?php

namespace App\Models\Team;

use App\Core\Image\SaveImage;
use App\Models\Notification\Notification;
use DB;

class TeamManager
{
    public function store($data)
    {
        $team = new Team($data);
        SaveImage::save($data['image'], $team);

        DB::transaction(function() use($data, $team) {
            $team->save();
            $this->storeMl($data['ml'], $team);
        });

        $notification = new Notification();
        $notification->send(route('admin_team_edit', $team->id), 'team');
    }

    public function update($id, $data)
    {
        $team = Team::where('id', $id)->firstOrFail();
        SaveImage::save($data['image'], $team);

        DB::transaction(function() use($data, $team) {
            $team->update($data);
            $this->updateMl($data['ml'], $team);
        });
    }

    protected function storeMl($data, Team $team)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new TeamMl($mlData);
        }
        $team->ml()->saveMany($ml);
    }

    protected function updateMl($data, Team $team)
    {
        TeamMl::where('id', $team->id)->delete();
        $this->storeMl($data, $team);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Team::where('id', $id)->delete();
            TeamMl::where('id', $id)->delete();
        });
    }
}