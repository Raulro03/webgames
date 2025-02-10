<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Platform;

class PagePlatformsController extends Controller
{
    public function index()
    {
        $platforms = Platform::query()->paginate(9);
        return view('pages.platforms', compact('platforms'));
    }

    public function show(Platform $platform)
    {
        return view('shows.platform', compact('platform'));
    }
}
