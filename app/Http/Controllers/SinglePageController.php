<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SinglePageController extends BaseController
{
    public function index()
    {
        return view('pages.single-page');
    }
}
