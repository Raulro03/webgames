<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Character;

class PageCharactersController extends Controller
{
    public function index()
    {
        $characters = Character::query()->paginate(9);
        return view('pages.characters', compact('characters'));
    }

    public function show(Character $character)
    {
        return view('shows.character', compact('character'));
    }
}
