<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class PagePlatformsController extends Controller
{
    public function invoke()
    {
        return view('pages.platforms');
    }
}
