<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;

class PageGamesController extends Controller
{
    public function index()
    {

        return view('pages.games');
    }


    public function show(Game $game)
    {
        return view('shows.game', compact('game'));
    }

    public function create()
    {
        return view('games.create');
    }

    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    public function destroy(Game $game)
    {

        if ($game->image_url) {
            Storage::disk('public')->delete($game->image_url);
        }

        $game->delete();

        return redirect()->route('games')->with('status', 'Juego eliminado exitosamente!');
    }

}
