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

    protected function set_hash()
    {
        $accountManager = new \App\Models\Account\AccountManager();
        $brands = \DB::table('creatives')->get();
        foreach ($brands as $brand) {
            $hash = $accountManager->generateRandomUniqueHash();
            \DB::table('creatives')->where('id', $brand->id)->update(['hash' => $hash]);
        }
    }

    protected function import_ads_details()
    {
        ini_set('memory_limit','250M');
        set_time_limit(1000);

        //\DB::table('commercial_credit_persons')->truncate();

        $brands = \DB::select("SELECT * FROM `commercial_creative_rel` LIMIT 50000, 10000");

        $data = [];
        foreach ($brands as $brand) {
            $data[] = [
                'credit_id' => $brand->com_cr_id,
                'type' => 'creative',
                'type_id' => $brand->creative_id,
                'name' => '',
                'separator' => $brand->creative_separator,
            ];
        }

        \DB::table('commercial_credit_persons')->insert($data);
    }

    protected function import_ads()
    {
        ini_set('memory_limit','250M');
        set_time_limit(1000);

        //\DB::table('commercials')->truncate();
        //\DB::table('commercials_ml')->truncate();

        $resources = \DB::select("SELECT * FROM `commercials` LIMIT 6000, 2000");
        $adv = \DB::select("SELECT * FROM `commercial_agency`");
        $advs = [];
        foreach ($adv as $val) {
            $advs[$val->commercial_id] = $val;
        }
        unset($adv);

        $data = [];
        $dataMl = [];
        foreach ($resources as $resource) {
            /*if ($resource->box == '1') {
                $filename = public_path('images/commercial/'.$resource->img);
                $img = \Intervention\Image\ImageManagerStatic::make($filename);
                $img->resize(150, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($filename);
            } else if ($resource->box == '3') {
                $filename = public_path('images/commercial/'.$resource->img);
                $img = \Intervention\Image\ImageManagerStatic::make($filename);
                $img->crop(150, 150, abs(156), 0);
                $img->save($filename);
            } else if ($resource->box == '4') {
                $filename = public_path('images/commercial/'.$resource->img);
                $img = \Intervention\Image\ImageManagerStatic::make($filename);
                $img->crop(150, 150, 0, abs(156));
                $img->save($filename);
            }*/
            $videoData = '';
            if ($resource->type == 'video') {
                if ($resource->video_type == 'youtube') {
                    $videoData = json_encode(['id' => $resource->v_id, 'url' => $resource->yt_link]);
                } else if ($resource->video_type == 'vimeo') {
                    $videoData = json_encode(['id' => $resource->vimeo_id, 'url' => 'https://vimeo.com/'.$resource->vimeo_id]);
                }
            }
            $data[] = [
                'id' => $resource->id,
                'media_type_id' => 0,
                'industry_type_id' => 0,
                'country_id' => $resource->country_id,
                'category_id' => 0,
                'alias' => $resource->url,
                'type' => $resource->type,
                'video_type' => $resource->type == 'video' ? $resource->video_type : '',
                'video_data' => $videoData,
                'image_print' => $resource->main_img,
                'featured' => '0',
                'top' => $resource->top,
                'published_date' => $resource->date,
                'image' => $resource->img,
                'advertising' => isset($advs[$resource->id]) ? $advs[$resource->id]->agency_title : '',
                'views_count' => $resource->views,
                'comments_count' => 0,
                'rating' => $resource->qt == 0 ? 0 : ($resource->rating/$resource->qt),
                'qt' => $resource->qt,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dataMl[] = [
                'id' => $resource->id,
                'lng_id' => 1,
                'title' => $resource->title_en,
                'description' => $resource->slogan,
            ];
        }
        \DB::table('commercials')->insert($data);
        \DB::table('commercials_ml')->insert($dataMl);
    }

    protected function import_brands()
    {
        $resources = \DB::select("SELECT * FROM `brands`");

        $data = [];
        $dataMl = [];
        foreach ($resources as $resource) {
            if ($resource->box == '1') {
                $filename = public_path('images/brand/'.$resource->img);
                $img = \Intervention\Image\ImageManagerStatic::make($filename);
                $img->resize(150, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($filename);
            }
            $data[] = [
                'id' => $resource->id,
                'country_id' => $resource->country_id,
                'category_id' => $resource->category_id,
                'alias' => $resource->url,
                'image' => $resource->img,
                'cover' => '',
                'email' => $resource->email,
                'password' => '',
                'phone' => $resource->phone,
                'link' => $resource->link,
                'top' => \App\Models\Brand\Brand::NOT_TOP,
                'fb' => '',
                'twitter' => '',
                'google' => '',
                'youtube' => '',
                'linkedin' => '',
                'vimeo' => '',
                'hash' => '',
                'status' => '',
                'active' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dataMl[] = [
                'id' => $resource->id,
                'lng_id' => 1,
                'title' => $resource->title_en,
                'sub_title' => '',
                'about' => $resource->desc_en,
                'address' => $resource->address_en
            ];
        }
        \DB::table('brands')->truncate();
        \DB::table('brands_ml')->truncate();
        \DB::table('brands')->insert($data);
        \DB::table('brands_ml')->insert($dataMl);
    }

    protected function import_agencies()
    {
        $resources = \DB::select("SELECT * FROM `companies`");

        $data = [];
        $dataMl = [];
        foreach ($resources as $resource) {
            if ($resource->box == '1') {
                $filename = public_path('images/agency/'.$resource->img);
                $img = \Intervention\Image\ImageManagerStatic::make($filename);
                $img->resize(150, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($filename);
            }
            $data[] = [
                'id' => $resource->id,
                'category_id' => 0,
                'alias' => $resource->url,
                'image' => $resource->img,
                'cover' => '',
                'email' => $resource->email,
                'password' => '',
                'phone' => $resource->phone,
                'link' => $resource->link,
                'top' => \App\Models\Agency\Agency::NOT_TOP,
                'fb' => '',
                'twitter' => '',
                'google' => '',
                'youtube' => '',
                'linkedin' => '',
                'vimeo' => '',
                'hash' => '',
                'status' => '',
                'active' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dataMl[] = [
                'id' => $resource->id,
                'lng_id' => 1,
                'title' => $resource->title_en,
                'sub_title' => '',
                'about' => $resource->desc_en,
                'address' => $resource->address_en
            ];
        }
        \DB::table('agencies')->truncate();
        \DB::table('agencies_ml')->truncate();
        \DB::table('agencies')->insert($data);
        \DB::table('agencies_ml')->insert($dataMl);
    }

    protected function import_creatives()
    {
        ini_set('memory_limit','250M');
        set_time_limit(1000);

        //\DB::table('creatives')->truncate();
        //\DB::table('creatives_ml')->truncate();
        //die;
        $resources = \DB::select("SELECT * FROM `creative` LIMIT 24000, 2000");

        $data = [];
        $dataMl = [];
        foreach ($resources as $resource) {
            $data[] = [
                'id' => $resource->id,
                'type' => 'personal',
                'type_id' => 0,
                'alias' => \App\Core\Util\MakeAlias::makeAliasStr($resource->name),
                'image' => '',
                'cover' => '',
                'email' => '',
                'password' => '',
                'phone' => '',
                'link' => '',
                'fb' => '',
                'twitter' => '',
                'google' => '',
                'youtube' => '',
                'linkedin' => '',
                'vimeo' => '',
                'hash' => '',
                'status' => '',
                'active' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dataMl[] = [
                'id' => $resource->id,
                'lng_id' => 1,
                'title' => $resource->name,
                'about' => ''
            ];
        }

        \DB::table('creatives')->insert($data);
        \DB::table('creatives_ml')->insert($dataMl);
    }

    public function import_countries()
    {
        $resources = \DB::select("SELECT * FROM `country`");

        $data = [];
        $dataMl = [];
        foreach ($resources as $resource) {
            $data[] = [
                'id' => $resource->id,
                'icon' => $resource->img,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dataMl[] = [
                'id' => $resource->id,
                'lng_id' => 1,
                'name' => $resource->name_en,
            ];
        }

        \DB::table('countries')->truncate();
        \DB::table('countries_ml')->truncate();
        \DB::table('countries')->insert($data);
        \DB::table('countries_ml')->insert($dataMl);
    }
}