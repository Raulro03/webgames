<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class PageGamesController extends Controller
{

    use AuthorizesRequests;

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
        $this->authorize('create', Game::class);

        return view('games.create');
    }

    public function edit(Game $game)
    {

        $this->authorize('update', $game);

        return view('games.edit', compact('game'));
    }

    public function destroy(Game $game)
    {

        $this->authorize('delete', $game);

        if ($game->image_url) {
            Storage::disk('public')->delete($game->image_url);
        }

        $game->platforms()->detach();
        $game->characters()->detach();

        $game->delete();

        return redirect()->route('games')->with('status', 'Juego eliminado exitosamente!');
    }

}
