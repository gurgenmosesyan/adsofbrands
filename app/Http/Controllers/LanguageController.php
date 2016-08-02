<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $lngCode = $request->input('code');

        $baseUrl = url('');
        $backUrl = redirect()->back()->getTargetUrl();

        $backUrl = str_replace($baseUrl, '', $backUrl);

        $pattern = '#^\/\S\S#i';
        $backUrl = preg_replace($pattern, '/'.$lngCode, $backUrl);

        return redirect($backUrl);
    }
}