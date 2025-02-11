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
        $this->characters = Character::all();
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

        $char1Score = $char1->statistics->constitution + $char1->statistics->strength + $char1->statistics->agility + $char1->statistics->intelligence + $char1->statistics->charisma;
        $char2Score = $char2->statistics->constitution + $char2->statistics->strength + $char2->statistics->agility + $char2->statistics->intelligence + $char2->statistics->charisma;

        if ($char1Score > $char2Score) {
            $this->winner = $char1;
        } elseif ($char1Score < $char2Score) {
            $this->winner = $char2;
        } else {
            $this->winner = 'Empate';
        }
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
