<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class PageCharactersController extends Controller
{
    public function invoke()
    {
        return view('pages.characters');
    }

}
