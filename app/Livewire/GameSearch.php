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

    public function updatingSearch()
    {
        if (empty(trim($this->search))) {
            $this->reset(['search']);
            $this->resetPage();
        }
    }

    public function toggleOrder()
    {
        $this->orderBy = $this->orderBy === 'desc' ? 'asc' : 'desc';
    }

    public function render()
    {
        $searchTerm = trim($this->search ?? '');

        $query = Game::query();

        if (!empty($searchTerm)) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        $games = $query->orderBy('average_rating', $this->orderBy)->paginate(9);

        return view('livewire.game-search', compact('games'));
    }
}
