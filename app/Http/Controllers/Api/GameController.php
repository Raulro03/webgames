<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;

class GameController extends Controller
{

    public function index()
    {
        return response()->json(Game::query()->paginate(10));

    }

    public function show(string $id)
    {
        return response()->json(Game::query()->find($id));
    }
}

