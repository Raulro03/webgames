<?php

namespace App\Http\Controllers;

class PageWelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
