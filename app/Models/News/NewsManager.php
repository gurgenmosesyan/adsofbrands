<?php

namespace App\Models\News;

use App\Core\Image\SaveImage;
use DB;

class NewsManager
{
    public function store($data)
    {
        $news = new News($data);
        SaveImage::save($data['image'], $news);

        DB::transaction(function() use($data, $news) {
            $news->save();
            $this->storeMl($data['ml'], $news);
            $this->updateBrands($data['brands'], $news);
            $this->updateAgencies($data['agencies'], $news);
            $this->updateCreatives($data['creatives'], $news);
        });
    }

    public function update($id, $data)
    {
        $news = News::where('id', $id)->firstOrFail();
        SaveImage::save($data['image'], $news);

        DB::transaction(function() use($data, $news) {
            $news->update($data);
            $this->updateMl($data['ml'], $news);
            $this->updateBrands($data['brands'], $news, true);
            $this->updateAgencies($data['agencies'], $news, true);
            $this->updateCreatives($data['creatives'], $news, true);
        });
    }

    protected function storeMl($data, News $news)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new NewsMl($mlData);
        }
        $news->ml()->saveMany($ml);
    }

    protected function updateMl($data, News $news)
    {
        NewsMl::where('id', $news->id)->delete();
        $this->storeMl($data, $news);
    }

    protected function updateBrands($data, News $news, $editMode = false)
    {
        if ($editMode) {
            $news->brands()->detach();
        }
        $news->brands()->attach($data);
    }

    protected function updateAgencies($data, News $news, $editMode = false)
    {
        if ($editMode) {
            $news->agencies()->detach();
        }
        $news->agencies()->attach($data);
    }

    protected function updateCreatives($data, News $news, $editMode = false)
    {
        if ($editMode) {
            $news->creatives()->detach();
        }
        $news->creatives()->attach($data);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            News::where('id', $id)->delete();
            NewsMl::where('id', $id)->delete();
            DB::table('news_brands')->where('news_id', $id)->delete();
            DB::table('news_agencies')->where('news_id', $id)->delete();
        });
    }
}