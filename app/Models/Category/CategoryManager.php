<?php

namespace App\Models\Category;

use App\Models\Notification\Notification;
use DB;

class CategoryManager
{
    public function store($data)
    {
        $category = new Category();

        DB::transaction(function() use($data, $category) {
            $category->save();
            $this->storeMl($data['ml'], $category);
        });

        $notification = new Notification();
        $notification->send(route('admin_category_edit', $category->id), 'industry type');
    }

    public function update($id, $data)
    {
        $category = Category::where('id', $id)->firstOrFail();

        DB::transaction(function() use($data, $category) {
            $category->save();
            $this->updateMl($data['ml'], $category);
        });
    }

    protected function storeMl($data, Category $category)
    {
        $ml = [];
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[] = new CategoryMl($mlData);
        }
        $category->ml()->saveMany($ml);
    }

    protected function updateMl($data, Category $category)
    {
        CategoryMl::where('id', $category->id)->delete();
        $this->storeMl($data, $category);
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Category::where('id', $id)->delete();
            CategoryMl::where('id', $id)->delete();
        });
    }
}