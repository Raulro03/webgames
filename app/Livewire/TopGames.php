<?php

namespace App\Livewire;

use App\Services\IGDBService;
use Livewire\Component;

class TopGames extends Component
{
    public $games;

    public function mount(IGDBService $igdbService)
    {
        $this->games = $igdbService->getTopGamesByPopularity(10);
    }

    public function render()
    {
        return view('livewire.top-games')->extends('layouts.webgames')->section('content');
    }
}
