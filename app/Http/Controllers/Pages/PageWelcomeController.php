<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class PageWelcomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome');
    }
}
