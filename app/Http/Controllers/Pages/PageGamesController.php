<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Game;

class PageGamesController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('pages.games', compact('games'));
    }

    /*public function create()
    {
        return view('games.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
        ]);

        Game::create($validatedData);

        return redirect()->route('games.index')->with('success', 'Game created successfully.');
    }*/

    public function show(Game $game)
    {
        return view('shows.game', compact('game'));
    }

    /*public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
        ]);

        $game->update($validatedData);

        return redirect()->route('games.index')->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {

    }*/
}
