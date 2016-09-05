<?php

namespace App\Http\Controllers;

use App\Models\News\News;

class NewsController extends Controller
{
    public function all()
    {
        $news = News::joinMl()->latest()->paginate(12);

        return view('news.all')->with([
            'news' => $news
        ]);
    }

    public function index($lngCode, $alias, $id)
    {
        $news = News::joinMl()->where('news.id', $id)->firstOrFail();
        if ($news->alias != $alias) {
            return redirect(url_with_lng('/news/'.$news->alias.'/'.$news->id));
        }

        $relNews = News::joinMl()->latest()->take(3)->get();

        return view('news.index')->with([
            'news' => $news,
            'relNews' => $relNews
        ]);
    }
}