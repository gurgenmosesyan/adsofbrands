<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\AgencyMl;
use App\Models\Brand\BrandMl;
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialCreditPerson;
use App\Models\Commercial\CommercialManager;
use App\Models\Commercial\CommercialSearch;
use App\Http\Requests\Admin\CommercialRequest;
use App\Core\Language\Language;
use App\Models\Category\Category;
use App\Models\Country\Country;
use App\Models\Creative\CreativeMl;
use App\Models\IndustryType\IndustryType;
use App\Models\MediaType\MediaType;

class CommercialController extends BaseController
{
    protected $manager = null;

    public function __construct(CommercialManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.commercial.index');
    }

    public function index(CommercialSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $commercial = new Commercial();
        $mediaTypes = MediaType::joinMl()->get();
        $industryTypes = IndustryType::joinMl()->get();
        $countries = Country::joinMl()->get();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        return view('admin.commercial.edit')->with([
            'commercial' => $commercial,
            'mediaTypes' => $mediaTypes,
            'industryTypes' => $industryTypes,
            'brands' => [],
            'agencies' => [],
            'countries' => $countries,
            'categories' => $categories,
            'advertisings' => [],
            'credits' => [],
            'languages' => $languages,
            'saveMode' => 'add'
        ]);
    }

    public function store(CommercialRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $commercial = Commercial::where('id', $id)->firstOrFail();
        $mediaTypes = MediaType::joinMl()->get();
        $industryTypes = IndustryType::joinMl()->get();
        $brands = $commercial->brands()->select('brands.id', 'ml.title')->joinMl()->get();
        $agencies = $commercial->agencies()->select('agencies.id', 'ml.title')->joinMl()->get();
        $countries = Country::joinMl()->get();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        $credits = $commercial->credits()->ordered()->with('persons')->get();
        foreach ($credits as $credit) {
            foreach ($credit->persons as $person) {
                if (!empty($person->type_id)) {
                    if ($person->isCreative()) {
                        $type = CreativeMl::where('id', $person->type_id)->first();
                    } else if ($person->isBrand()) {
                        $type = BrandMl::where('id', $person->type_id)->first();
                    } else {
                        $type = AgencyMl::where('id', $person->type_id)->first();
                    }
                    $person->name = '@'.$type->title;
                }
            }
        }

        return view('admin.commercial.edit')->with([
            'commercial' => $commercial,
            'mediaTypes' => $mediaTypes,
            'industryTypes' => $industryTypes,
            'brands' => $brands,
            'agencies' => $agencies,
            'countries' => $countries,
            'categories' => $categories,
            'advertisings' => $commercial->advertisings,
            'credits' => $credits,
            'languages' => $languages,
            'saveMode' => 'edit'
        ]);
    }

    public function update(CommercialRequest $request, $id)
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