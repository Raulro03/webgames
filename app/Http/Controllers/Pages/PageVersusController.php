<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Character;

class PageVersusController extends Controller
{
    public function index()
    {
        return view('pages.versus');
    }
}
