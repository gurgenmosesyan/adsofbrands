<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\FooterMenu\FooterMenu;
use Route;

class FooterMenuRequest extends Request
{
    public function rules()
    {
        $static = $this->get('static');
        $textReqRule = 'required|';
        if ($static == FooterMenu::IS_STATIC) {
            $textReqRule = '';
        }

        $menuId = '';
        $params = Route::getCurrentRoute()->parameters();
        if (isset($params['id'])) {
            $menuId = ','.$params['id'];
        }

        return [
            'alias' => 'required|max:255|unique:footer_menu,alias'.$menuId,
            'hidden' => 'in:'.FooterMenu::HIDDEN.','.FooterMenu::NOT_HIDDEN,
            'sort_order' => 'integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.text' => $textReqRule.'max:65000'
        ];
    }
}