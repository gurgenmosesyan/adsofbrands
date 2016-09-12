<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Agency\AgencyMl;
use App\Models\Brand\BrandMl;
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialCredit;
use App\Models\Commercial\CommercialCreditPerson;
use App\Models\Commercial\CommercialManager;
use App\Models\Commercial\CommercialSearch;
use App\Http\Requests\Admin\CommercialRequest;
use App\Core\Language\Language;
use App\Models\Category\Category;
use App\Models\Country\Country;
use App\Models\Creative\CreativeMl;
use App\Models\MediaType\MediaType;
use Illuminate\Http\Request;
use Auth;

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
        $countries = Country::joinMl()->get();
        $categories = Category::joinMl()->get();
        $languages = Language::all();

        $credits = [];
        if (Auth::guard('creative')->check()) {
            $query = Auth::guard('creative')->user();
            $creative = $query->joinMl()->first();
            $credits = [
                [
                    'id' => '',
                    'commercial_id' => $commercial->id,
                    'position' => '',
                    'sort_order' => '',
                    'persons' => [
                        [
                            'credit_id' => '',
                            'type' => 'creative',
                            'type_id' => $creative->id,
                            'name' => '@'.$creative->title,
                            'separator' => ','
                        ]
                    ]
                ]
            ];
        }

        return view('admin.commercial.edit')->with([
            'commercial' => $commercial,
            'mediaTypes' => $mediaTypes,
            'brands' => [],
            'agencies' => [],
            'countries' => $countries,
            'categories' => $categories,
            'advertisings' => [],
            'credits' => $credits,
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
        $query = Commercial::where('id', $id);
        if (Auth::guard('brand')->check()) {
            $brand = Auth::guard('brand')->user();
            $query->join('commercial_brands as brands', function($query) use($brand) {
                $query->on('brands.commercial_id', '=', 'commercials.id')->where('brands.brand_id', '=', $brand->id);
            });
        } else if (Auth::guard('agency')->check()) {
            $agency = Auth::guard('agency')->user();
            $query->join('commercial_agencies as agencies', function($query) use($agency) {
                $query->on('agencies.commercial_id', '=', 'commercials.id')->where('agencies.agency_id', '=', $agency->id);
            });
        } else if (Auth::guard('creative')->check()) {
            $creative = Auth::guard('creative')->user();
            $commercialIds = CommercialCredit::join('commercial_credit_persons as person', function($query) use($creative) {
                $query->on('person.credit_id', '=', 'commercial_credits.id')->where('person.type', '=', CommercialCreditPerson::TYPE_CREATIVE)->where('type_id', '=', $creative->id);
            })->lists('commercial_credits.commercial_id')->toArray();
            $query->whereIn('id', $commercialIds);
        }
        $commercial = $query->firstOrFail();

        $mediaTypes = MediaType::joinMl()->get();
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

    public function brand(Request $request)
    {
        $title = $request->input('title');
        $skipIds = $request->input('skip_ids');
        $brands = BrandMl::where('title', 'LIKE', '%'.$title.'%')->whereNotIn('id', $skipIds)->get();
        return $this->api('OK', $brands);
    }

    public function agency(Request $request)
    {
        $title = $request->input('title');
        $skipIds = $request->input('skip_ids');
        $brands = AgencyMl::where('title', 'LIKE', '%'.$title.'%')->whereNotIn('id', $skipIds)->get();
        return $this->api('OK', $brands);
    }

    public function creative(Request $request)
    {
        $title = $request->input('title');
        $skipIds = $request->input('skip_ids');
        $brands = CreativeMl::where('title', 'LIKE', '%'.$title.'%')->whereNotIn('id', $skipIds)->get();
        return $this->api('OK', $brands);
    }
}