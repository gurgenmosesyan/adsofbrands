<?php

namespace App\Http\Controllers;

use App\Models\Commercial\Commercial;

class IndexController extends Controller
{
    public function index()
    {


        return view('index.index')->with([

        ]);
    }
}