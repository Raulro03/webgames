<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Game;

class PageGamesController extends Controller
{
    public function index()
    {
        $games = Game::query()->paginate(9);
        return view('pages.games', compact('games'));
    }


    public function show(Game $game)
    {
        return view('shows.game', compact('game'));
    }

}
