<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\News\News;
use App\Models\News\NewsManager;
use App\Models\News\NewsSearch;
use App\Http\Requests\Admin\NewsRequest;
use App\Core\Language\Language;

class NewsController extends BaseController
{
    protected $manager = null;

    public function __construct(NewsManager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.news.index');
    }

    public function index(NewsSearch $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $news = new News();
        $languages = Language::all();

        return view('admin.news.edit')->with([
            'news' => $news,
            'languages' => $languages,
            'brands' => [],
            'agencies' => [],
            'creatives' => [],
            'saveMode' => 'add'
        ]);
    }

    public function store(NewsRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $news = News::where('id', $id)->firstOrFail();
        $languages = Language::all();
        $brands = $news->brands()->select('brands.id', 'ml.title')->joinMl()->get();
        $agencies = $news->agencies()->select('agencies.id', 'ml.title')->joinMl()->get();
        $creatives = $news->creatives()->select('creatives.id', 'ml.title')->joinMl()->get();

        return view('admin.news.edit')->with([
            'news' => $news,
            'languages' => $languages,
            'brands' => $brands,
            'agencies' => $agencies,
            'creatives' => $creatives,
            'saveMode' => 'edit'
        ]);
    }

    public function update(NewsRequest $request, $id)
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