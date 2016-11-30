<?php

namespace App\Http\Controllers;

use App\Models\FooterMenu\FooterMenu;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected function getPage($alias, Request $request)
    {
        $hash = $request->input('hash');
        $query = FooterMenu::joinMl()->where('footer_menu.alias', $alias);
        if (empty($hash)) {
            return $query->where('footer_menu.show_status', FooterMenu::STATUS_ACTIVE)->firstOrFail();
        } else {
            $page = $query->firstOrFail();
            if ($page->show_status == FooterMenu::STATUS_ACTIVE) {
                return $page;
            }
            if ($hash !== $page->hash) {
                abort(404);
            }
            return $page;
        }
    }

    public function index($lngCode, $alias, Request $request)
    {
        $page = $this->getPage($alias, $request);

        return view('page.index')->with([
            'page' => $page
        ]);
    }
}