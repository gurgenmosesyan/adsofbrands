<?php

namespace App\Http\Controllers;

use App\Models\Brand\Brand;
use App\Models\Commercial\Commercial;
use App\Models\Commercial\CommercialCreditPerson;
use App\Models\Creative\Creative;
use DB;

class CreativeController extends Controller
{
    public function index($lngCode, $alias, $id)
    {
        $creative = Creative::joinMl()->where('creatives.id', $id)->firstOrFail();
        if ($creative->alias != $alias) {
            return redirect(url_with_lng('/creative/'.$creative->alias.'/'.$creative->id));
        }
        $alias = 'ads';
        $commercialIds = CommercialCreditPerson::select('credits.commercial_id')
            ->join('commercial_credits as credits', function($query) {
                $query->on('credits.id', '=', 'commercial_credit_persons.credit_id');
            })
            ->where('commercial_credit_persons.type', CommercialCreditPerson::TYPE_CREATIVE)
            ->where('commercial_credit_persons.type_id', $creative->id)->lists('commercial_id')->toArray();
        $items = Commercial::joinMl()->whereIn('commercials.id', $commercialIds)->get();
        return view('creative.index')->with([
            'creative' => $creative,
            'alias' => $alias,
            'items' => $items
        ]);
    }

    public function brands($lngCode, $alias, $id)
    {
        $creative = Creative::joinMl()->where('creatives.id', $id)->firstOrFail();
        if ($creative->alias != $alias) {
            return redirect(url_with_lng('/creative/'.$creative->alias.'/'.$creative->id));
        }
        $alias = 'clients';
        $commercialIds = CommercialCreditPerson::select('credits.commercial_id')
            ->join('commercial_credits as credits', function($query) {
                $query->on('credits.id', '=', 'commercial_credit_persons.credit_id');
            })
            ->where('commercial_credit_persons.type', CommercialCreditPerson::TYPE_CREATIVE)
            ->where('commercial_credit_persons.type_id', $creative->id)->lists('commercial_id')->toArray();
        $items = Brand::joinMl()->join('commercial_brands as c_brands', function($query) {
            $query->on('c_brands.brand_id', '=', 'brands.id');
        })->whereIn('c_brands.commercial_id', $commercialIds);
        return view('creative.index')->with([
            'creative' => $creative,
            'alias' => $alias,
            'items' => $items
        ]);
    }

    public function awards($lngCode, $alias, $id)
    {
        $creative = Creative::joinMl()->where('creatives.id', $id)->firstOrFail();
        if ($creative->alias != $alias) {
            return redirect(url_with_lng('/creative/'.$creative->alias.'/'.$creative->id));
        }
        $alias = 'awards';
        $awards = $creative->awards()->joinMl()->orderBy('awards.year', 'desc')->get();
        return view('creative.index')->with([
            'creative' => $creative,
            'alias' => $alias,
            'awards' => $awards
        ]);
    }

    public function about($lngCode, $alias, $id)
    {
        $creative = Creative::joinMl()->where('creatives.id', $id)->firstOrFail();
        if ($creative->alias != $alias) {
            return redirect(url_with_lng('/creative/'.$creative->alias.'/'.$creative->id));
        }
        $alias = 'about';
        return view('creative.index')->with([
            'creative' => $creative,
            'alias' => $alias
        ]);
    }
}