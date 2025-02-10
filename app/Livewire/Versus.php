<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Character;

class Versus extends Component
{
    public $characters;
    public $selectedCharacters = [];
    public $winner;

    public function mount()
    {
        $this->characters = Character::all(); // Cargar todos los personajes
    }

    public function selectCharacter($characterId)
    {
        if (count($this->selectedCharacters) < 2) {
            $this->selectedCharacters[] = Character::find($characterId);
        }

        if (count($this->selectedCharacters) == 2) {
            $this->compareCharacters();
        }
    }

    public function compareCharacters()
    {
        [$char1, $char2] = $this->selectedCharacters;

        $char1Score = $char1->strength + $char1->speed + $char1->intelligence;
        $char2Score = $char2->strength + $char2->speed + $char2->intelligence;

        $this->winner = $char1Score > $char2Score ? $char1 : $char2;
    }

    public function resetSelection()
    {
        $this->selectedCharacters = [];
        $this->winner = null;
    }

    public function render()
    {
        return view('livewire.versus');
    }
}
