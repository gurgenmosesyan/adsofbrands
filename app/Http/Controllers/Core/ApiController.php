<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Core\Util\MakeAlias;

class ApiController extends BaseController
{
    public function makeAlias(Request $request)
    {
        return $this->api('OK', MakeAlias::makeAliasStr($request->input('title')));
    }
}