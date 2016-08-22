<?php

namespace App\Models\Vacancy;

use Auth;
use DB;

class VacancyManager
{
    public function store($data)
    {
        $vacancy = new Vacancy($data);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $vacancy->type = Vacancy::TYPE_BRAND;
            $vacancy->type_id = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $vacancy->type = Vacancy::TYPE_AGENCY;
            $vacancy->type_id = $agency->id;
        }

        DB::transaction(function() use($data, $vacancy) {
            $vacancy->save();
            $this->storeMl($data['ml'], $vacancy);
        });
    }

    public function update($id, $data)
    {
        $query = Vacancy::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Vacancy::TYPE_BRAND)->where('type_id', $brand->id);
            $data['type'] = Vacancy::TYPE_BRAND;
            $data['type_id'] = $brand->id;
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Vacancy::TYPE_AGENCY)->where('type_id', $agency->id);
            $data['type'] = Vacancy::TYPE_AGENCY;
            $data['type_id'] = $agency->id;
        }
        $vacancy = $query->firstOrFail();

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
        $query = Vacancy::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->where('type', Vacancy::TYPE_BRAND)->where('type_id', $brand->id);
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->where('type', Vacancy::TYPE_AGENCY)->where('type_id', $agency->id);
        }
        $vacancy = $query->firstOrFail();

        DB::transaction(function() use($vacancy) {
            $vacancy->delete();
            VacancyMl::where('id', $vacancy->id)->delete();
        });
    }
}