<?php

namespace App\Http\Controllers;

use App\Models\Agency\AgencyMl;
use App\Models\Brand\BrandMl;
use App\Models\Category\CategoryMl;
use App\Models\Commercial\Commercial;
use App\Models\Country\CountryMl;
use App\Models\Creative\CreativeMl;
use App\Models\IndustryType\IndustryTypeMl;
use App\Models\MediaType\MediaTypeMl;
use Illuminate\Http\Request;

class CommercialController extends Controller
{
    public function all(Request $request)
    {
        $mediaTypes = MediaTypeMl::current()->get();
        $industryTypes = IndustryTypeMl::current()->get();
        $countries = CountryMl::current()->get();
        $categories = CategoryMl::current()->get();

        $mediaTypeId = $request->input('media');
        $industryTypeId = $request->input('industry');
        $countryId = $request->input('country');
        $categoryId = $request->input('category');
        $date = $request->input('date');

        $featuredAds = Commercial::joinMl()->where('featured', Commercial::FEATURED)->latest()->take(7)->get();
        $skipIds = [];
        foreach ($featuredAds as $value) {
            $skipIds[] = $value->id;
        }
        $query = Commercial::joinMl()->whereNotIn('commercials.id', $skipIds);
        if (!empty($mediaTypeId)) {
            $query->where('commercials.media_type_id', $mediaTypeId);
        }
        if (!empty($industryTypeId)) {
            $query->where('commercials.industry_type_id', $industryTypeId);
        }
        if (!empty($countryId)) {
            $query->where('commercials.country_id', $countryId);
        }
        if (!empty($categoryId)) {
            $query->where('commercials.category_id', $categoryId);
        }
        if (!empty($date)) {
            $query->where('commercials.published_date', $date);
        }
        $commercials = $query->orderBy('commercials.published_date', 'desc')->latest()->paginate(35);

        return view('commercial.all')->with([
            'mediaTypes' => $mediaTypes,
            'industryTypes' => $industryTypes,
            'countries' => $countries,
            'categories' => $categories,
            'mediaTypeId' => $mediaTypeId,
            'industryTypeId' => $industryTypeId,
            'countryId' => $countryId,
            'categoryId' => $categoryId,
            'date' => $date,
            'featuredAds' => $featuredAds,
            'commercials' => $commercials
        ]);
    }

    public function index($lngCode, $alias, $id)
    {
        $ad = Commercial::joinMl()->where('commercials.id', $id)->firstOrFail();
        if ($ad->alias != $alias) {
            return redirect(url_with_lng('/ads/'.$ad->alias.'/'.$ad->id));
        }

        $prevAd = Commercial::joinMl()->where('commercials.id', '>', $ad->id)->orderBy('commercials.id', 'asc')->first();
        $nextAd = Commercial::joinMl()->where('commercials.id', '<', $ad->id)->orderBy('commercials.id', 'desc')->first();

        $topAds = Commercial::joinMl()->where('commercials.top', Commercial::TOP)->latest()->take(3)->get();

        $credits = $ad->credits()->ordered()->with('persons')->get();
        foreach ($credits as $value) {
            foreach ($value->persons as $person) {
                if ($person->type_id != 0) {
                    if ($person->type == 'brand') {
                        $item = BrandMl::where('id', $person->type_id)->first();
                    } else if ($person->type == 'agency') {
                        $item = AgencyMl::where('id', $person->type_id)->first();
                    } else {
                        $item = CreativeMl::where('id', $person->type_id)->first();
                    }
                    $person->name = $item == null ? '' : $item->title;
                }
            }
        }

        return view('commercial.index')->with([
            'ad' => $ad,
            'prevAd' => $prevAd,
            'nextAd' => $nextAd,
            'topAds' => $topAds,
            'credits' => $credits
        ]);
    }
}