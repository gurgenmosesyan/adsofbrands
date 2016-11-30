<?php

namespace App\Http\Controllers;

use App\Models\Agency\Agency;
use App\Models\Brand\Brand;
use App\Models\Category\CategoryMl;
use App\Models\Country\CountryMl;
use App\Models\Commercial\CommercialCredit;
use App\Models\Commercial\CommercialCreditPerson;
use Illuminate\Http\Request;
use DB;

class BrandController extends Controller
{
    public function all(Request $request)
    {
        $countries = CountryMl::current()->get();
        $categories = CategoryMl::current()->get();

        $countryId = $request->input('country');
        $categoryId = $request->input('category');

        $query = Brand::joinMl()->where('brands.show_status', Brand::STATUS_ACTIVE);
        if (!empty($countryId)) {
            $query->where('brands.country_id', $countryId);
        }
        if (!empty($categoryId)) {
            $query->where('brands.category_id', $categoryId);
        }
        $brands = $query->latest()->paginate(42);

        return view('brand.all')->with([
            'countries' => $countries,
            'categories' => $categories,
            'countryId' => $countryId,
            'categoryId' => $categoryId,
            'brands' => $brands
        ]);
    }

    protected function getBrand($id, Request $request)
    {
        $hash = $request->input('hash');
        $query = Brand::joinMl()->where('brands.id', $id);
        if (empty($hash)) {
            return $query->where('brands.show_status', Brand::STATUS_ACTIVE)->firstOrFail();
        } else {
            $brand = $query->firstOrFail();
            if ($brand->show_status == Brand::STATUS_ACTIVE) {
                return $brand;
            }
            $conf = config('main.show_status');
            if ($hash !== $conf['start_salt'].$brand->hash.$conf['end_salt']) {
                abort(404);
            }
            return $brand;
        }
    }

    public function index($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'ads';
        $scroll = $request->input('ads');

        $items = $brand->commercials()->select('ml.title')->joinMl()->latest()->paginate(42);
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items,
            'scroll' => $scroll
        ]);
    }

    public function creatives($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'creatives';
        $items = $brand->creatives()->joinMl()->latest()->paginate(42);
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items,
            'scroll' => true
        ]);
    }

    public function awards($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'awards';
        $awards = $brand->awards()->joinMl()->orderBy('awards.year', 'desc')->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'awards' => $awards,
            'scroll' => true
        ]);
    }

    public function vacancies($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'vacancies';
        $vacancies = $brand->vacancies()->joinMl()->latest()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'vacancies' => $vacancies,
            'scroll' => true
        ]);
    }

    public function news($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'news';
        $news = $brand->news()->select('news.id','news.alias','news.image','ml.title','ml.description')->joinMl()->latest()->paginate(12);
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'news' => $news,
            'scroll' => true
        ]);
    }

    public function agencies($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'agencies';

        $adIds = DB::table('commercial_brands')->where('brand_id', $brand->id)->lists('commercial_id');

        $agencyIds = DB::table('commercial_agencies')->whereIn('commercial_id', $adIds)->lists('agency_id');

        $creditAgencyIds = CommercialCredit::join('commercial_credit_persons as person', function($query) {
                $query->on('person.credit_id', '=', 'commercial_credits.id')->where('person.type', '=', CommercialCreditPerson::TYPE_AGENCY);
            })
            ->whereIn('commercial_credits.commercial_id', $adIds)
            ->lists('type_id')->toArray();

        $agencyIds = array_merge($agencyIds, $creditAgencyIds);

        $items = Agency::joinMl()->whereIn('agencies.id', $agencyIds)->latest()->paginate(42);

        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'items' => $items,
            'scroll' => true
        ]);
    }

    public function about($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'about';
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'scroll' => true
        ]);
    }

    public function branches($lngCode, $alias, $id, Request $request)
    {
        $brand = $this->getBrand($id, $request);
        if ($brand->alias != $alias) {
            return redirect(url_with_lng('/brands/'.$brand->alias.'/'.$brand->id));
        }
        $alias = 'contacts';
        $branches = $brand->branches()->joinMl()->latest()->get();
        return view('brand.index')->with([
            'brand' => $brand,
            'alias' => $alias,
            'branches' => $branches,
            'scroll' => true
        ]);
    }
}