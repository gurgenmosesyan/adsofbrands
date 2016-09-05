<?php

namespace App\Http\Controllers;

use App\Models\FooterMenu\FooterMenu;

class PageController extends Controller
{
    public function index($lngCode, $alias)
    {
        $page = FooterMenu::joinMl()->where('alias', $alias)->firstOrFail();

        return view('page.index')->with([
            'page' => $page
        ]);
    }
}