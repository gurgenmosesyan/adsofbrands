<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\FooterMenu\FooterMenu;

class FooterMenuRequest extends Request
{
    public function rules()
    {
        $static = $this->get('static');
        $textReqRule = 'required|';
        if ($static == FooterMenu::IS_STATIC) {
            $textReqRule = '';
        }

        return [
            'alias' => 'required|max:255',
            'sort_order' => 'integer',
            'ml' => 'ml',
            'ml.*.title' => 'required|max:255',
            'ml.*.text' => $textReqRule.'max:65000'
        ];
    }
}