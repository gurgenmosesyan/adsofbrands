<?php

namespace App\Http\Controllers;

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
        $items = $creative->commercials()->select('commercials.id','commercials.alias','commercials.image','commercials.rating','commercials.comments_count','commercials.views_count','ml.title')->joinMl()->get();
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
        $alias = 'creatives';
        $items = $creative->creatives()->joinMl()->get();
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