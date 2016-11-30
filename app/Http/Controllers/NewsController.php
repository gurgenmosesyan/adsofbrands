<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News\News;

class NewsController extends Controller
{
    public function all()
    {
        $news = News::joinMl()->where('news.show_status', News::STATUS_ACTIVE)->latest()->paginate(12);

        return view('news.all')->with([
            'news' => $news
        ]);
    }

    protected function getNews($id, Request $request)
    {
        $hash = $request->input('hash');
        $query = News::joinMl()->where('news.id', $id);
        if (empty($hash)) {
            return $query->where('news.show_status', News::STATUS_ACTIVE)->firstOrFail();
        } else {
            $news = $query->firstOrFail();
            if ($news->show_status == News::STATUS_ACTIVE) {
                return $news;
            }
            if ($hash !== $news->hash) {
                abort(404);
            }
            return $news;
        }
    }

    public function index($lngCode, $alias, $id, Request $request)
    {
        $news = $this->getNews($id, $request);
        if ($news->alias != $alias) {
            return redirect(url_with_lng('/news/'.$news->alias.'/'.$news->id));
        }

        $relNewsIds = $news->tags()->select('tag2.news_id')->join('news_tags as tag2', function($query) use($news) {
            $query->on('tag2.tag', '=', 'news_tags.tag')->where('tag2.news_id', '!=', $news->id);
        })->lists('news_id')->toArray();

        $relNews = News::joinMl()->whereIn('news.id', $relNewsIds)->latest()->take(3)->get();

        return view('news.index')->with([
            'news' => $news,
            'relNews' => $relNews
        ]);
    }
}