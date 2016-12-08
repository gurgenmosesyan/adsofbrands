<?php

namespace App\Models\News;

use App\Core\Image\SaveImage;
use App\Models\Notification\Notification;
use DB;

class NewsManager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $news = new News($data);
        $news->hash = $this->generateRandomUniqueHash();
        SaveImage::save($data['image'], $news);

        DB::transaction(function() use($data, $news) {
            $news->save();
            $this->storeMl($data['ml'], $news);
            $this->updateBrands($data['brands'], $news);
            $this->updateAgencies($data['agencies'], $news);
            $this->updateCreatives($data['creatives'], $news);
            $this->updateTags($data['tags'], $news);
            $this->storeImages($data['images'], $news);
        });

        $notification = new Notification();
        $notification->send(route('admin_news_edit', $news->id), 'news');
    }

    protected function generateRandomUniqueHash($count = 40)
    {
        $hash = str_random($count);
        $news = News::where('hash', $hash)->first();
        if ($news == null) {
            return $hash;
        }
        return $this->generateRandomUniqueHash();
    }

    public function update($id, $data)
    {
        $news = News::where('id', $id)->firstOrFail();
        $data = $this->processSave($data);
        SaveImage::save($data['image'], $news);

        DB::transaction(function() use($data, $news) {
            $news->update($data);
            $this->updateMl($data['ml'], $news);
            $this->updateBrands($data['brands'], $news, true);
            $this->updateAgencies($data['agencies'], $news, true);
            $this->updateCreatives($data['creatives'], $news, true);
            $this->updateTags($data['tags'], $news, true);
            $this->updateImages($data['images'], $news);
        });
    }

    protected function processSave($data)
    {
        if (!isset($data['brands'])) {
            $data['brands'] = [];
        }
        if (!isset($data['agencies'])) {
            $data['agencies'] = [];
        }
        if (!isset($data['creatives'])) {
            $data['creatives'] = [];
        }
        if (!isset($data['tags'])) {
            $data['tags'] = [];
        }
        if (!isset($data['images'])) {
            $data['images'] = [];
        }
        return $data;
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

    protected function updateTags($data, News $news, $editMode = false)
    {
        if ($editMode) {
            NewsTag::where('news_id', $news->id)->delete();
        }
        $tags = [];
        foreach ($data as $value) {
            $tags[] = new NewsTag($value);
        }
        if (!empty($tags)) {
            $news->tags()->saveMany($tags);
        }
    }

    protected function storeImages($data, News $news)
    {
        foreach ($data as $value) {
            if (!empty($value['image'])) {
                $image = new NewsImage(['news_id' => $news->id, 'show_status' => News::STATUS_ACTIVE]);
                SaveImage::save($value['image'], $image);
                $image->save();
            }
        }
    }

    protected function updateImages($data, News $news)
    {
        NewsImage::where('news_id', $news->id)->update(['show_status' => News::STATUS_DELETED]);
        $newImages = [];
        foreach ($data as $value) {
            if (empty($value['id'])) {
                $newImages[] = $value;
            } else {
                $image = NewsImage::where('id', $value['id'])->firstOrFail();
                SaveImage::save($value['image'], $image);
                $image->show_status = empty($value['image']) ? News::STATUS_DELETED : News::STATUS_ACTIVE;
                $image->save();
            }
        }
        if (!empty($newImages)) {
            $this->storeImages($newImages, $news);
        }
        NewsImage::where('show_status', News::STATUS_DELETED)->delete();
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            News::where('id', $id)->delete();
            NewsMl::where('id', $id)->delete();
            DB::table('news_brands')->where('news_id', $id)->delete();
            DB::table('news_agencies')->where('news_id', $id)->delete();
            DB::table('news_creatives')->where('news_id', $id)->delete();
        });
    }
}