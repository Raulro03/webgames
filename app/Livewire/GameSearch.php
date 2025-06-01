<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Game;

class GameSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $orderBy = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'orderBy' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleOrder()
    {
        $this->orderBy = $this->orderBy === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function render()
    {
        $searchTerm = trim($this->search);

        $games = Game::filterAndOrder($searchTerm, $this->orderBy)->paginate(9);

        return view('livewire.game-search', compact('games'));
    }
}
