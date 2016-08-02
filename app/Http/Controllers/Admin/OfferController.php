<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Offer\Offer;
use App\Models\Offer\Manager;
use App\Models\Offer\OfferText;
use App\Models\Offer\Search;
use App\Http\Requests\Admin\OfferRequest;
use App\Core\Language\Language;
use App\Http\Requests\Admin\OfferTextRequest;

class OfferController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.offer.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $offer = new Offer();
        $languages = Language::all();
        return view('admin.offer.edit')->with([
            'offer' => $offer,
            'languages' => $languages,
            'images' => [],
            'saveMode' => 'add'
        ]);
    }

    public function store(OfferRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        $languages = Language::all();
        return view('admin.offer.edit')->with([
            'offer' => $offer,
            'languages' => $languages,
            'images' => $offer->images,
            'saveMode' => 'edit'
        ]);
    }

    public function update(OfferRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }

    public function text()
    {
        $texts = OfferText::get()->keyBy('lng_id');
        $languages = Language::all();

        return view('admin.offer.text')->with([
            'texts' => $texts,
            'languages' => $languages
        ]);
    }

    public function updateText(OfferTextRequest $request)
    {
        $this->manager->updateText($request->all());
        return $this->api('OK');
    }
}