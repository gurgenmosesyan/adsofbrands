<?php

namespace App\Models\Vacancy;

use DB;

class Manager
{
    public function store($data)
    {
        $vacancy = new Vacancy($data);
        DB::transaction(function() use($data, $vacancy) {
            $vacancy->save();
            $this->storeMl($data['ml'], $vacancy);
        });
    }

    public function update($id, $data)
    {
        $vacancy = Vacancy::findOrFail($id);
        DB::transaction(function() use($data, $vacancy) {
            $vacancy->update($data);
            $this->updateMl($data['ml'], $vacancy);
        });
    }

    protected function storeMl($data, Vacancy $vacancy)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new VacancyMl($mlData);
        }
        $vacancy->ml()->saveMany($ml);
    }

    protected function updateMl($data, Vacancy $vacancy)
    {
        VacancyMl::where('id', $vacancy->id)->delete();
        $this->storeMl($data, $vacancy);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Vacancy::where('id', $id)->delete();
            VacancyMl::where('id', $id)->delete();
        });
    }
}