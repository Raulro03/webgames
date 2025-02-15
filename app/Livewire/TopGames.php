<?php

namespace App\Livewire;

use App\Services\IGDBService;
use Livewire\Component;

class TopGames extends Component
{
    public $games = [];
    public $limit = 10;


    public function mount()
    {
        $this->fetchGames(); // Cargar juegos al iniciar el componente
    }

    public function loadMore()
    {
        $this->limit += 10;
        $this->fetchGames();
    }

    public function loadLess()
    {
        if ($this->limit > 10) {
            $this->limit -= 10;
        }
        $this->fetchGames();
    }

    public function fetchGames()
    {
        set_time_limit(60);
        $igdb = new IGDBService();
        $this->games = $igdb->getTopGamesByPopularity($this->limit);
    }

    public function render()
    {
        return view('livewire.top-games')->extends('layouts.webgames')->section('content');
    }
}
