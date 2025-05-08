<?php

namespace App\Livewire;

use App\Models\Character;
use App\Models\Platform;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Game;
use App\Models\Developer;

class GameFormFields extends Component
{
    use WithFileUploads;

    public $game;
    public $title;
    public $description;
    public $price;
    public $release_date;
    public $average_rating;
    public $developer_id;
    public $image;
    public $imagePreview;
    public $developers;
    public $platforms;
    public $selectedPlatforms = [];
    public $platformSales = [];
    public $characters;
    public $selectedCharacters = [];
    public $characterAppearance = [] ;

    protected $rules = [
        'title' => 'required|string|min:10|max:255',
        'description' => 'nullable|string',
        'release_date' => 'required|date',
        'average_rating' => 'nullable|numeric|between:0,9.99',
        'price' => 'required|integer|max:999999',
        'developer_id' => 'required',
        'selectedPlatforms' => 'nullable|array',
        'selectedPlatforms.*' => 'required|integer|min:0',
        'platformSales' => 'nullable|array',
        'platformSales.*' => 'required|integer|min:0',
        'selectedCharacters' => 'nullable|array',
        'selectedCharacters.*' => 'required|integer|min:0',
        'characterAppearance' => 'nullable|array',
        'characterAppearance.*' => 'required|date',
        'image' => 'nullable|image',
    ];

    public function mount($game = null)
    {
        $this->platforms = Platform::all();
        $this->developers = Developer::all();
        $this->characters = Character::all();

        if ($game) {
            $this->title = $game->title;
            $this->description = $game->description;
            $this->price = $game->price;
            $this->release_date = optional($game->release_date)->format('Y-m-d');
            $this->average_rating = $game->average_rating;
            $this->developer_id = $game->developer_id;
            foreach ($game->platforms as $platform) {
                $this->selectedPlatforms[$platform->id] = $platform->pivot->sales;
            }
            foreach ($game->characters as $character) {
                $this->selectedCharacters[$character->id] = $character->pivot->appearance;
            }
            $this->imagePreview = $game->image_url ? asset('storage/' . $game->image_url) : null;
        }
    }

    public function togglePlatform($platformId)
    {
        if (isset($this->selectedPlatforms[$platformId])) {
            unset($this->selectedPlatforms[$platformId]);
            unset($this->platformSales[$platformId]);
        } else {
            $this->selectedPlatforms[$platformId] = true;
            $this->platformSales[$platformId] = 0;
        }
    }

    public function toggleCharacter($characterId)
    {
        if (isset($this->selectedCharacters[$characterId])) {
            unset($this->selectedCharacters[$characterId]);
            unset($this->characterAppearance[$characterId]);
        } else {
            $this->selectedCharacters[$characterId] = true;
            $this->characterAppearance[$characterId] = null;
        }
    }

    public function updatedImage()
    {
        $this->validate(['image' => 'image|max:2048']);

        try {
            $this->imagePreview = $this->image->temporaryUrl();
        } catch ( \Exception) {
            $this->addError('image', 'No se pudo cargar la vista previa.');
        }
    }

    public function save()
    {

        $validatedData = $this->validate();

        $validatedData['image_url'] = $this->handleImageUpload();

        $game = Game::updateOrCreate(
            ['id' => optional($this->game)->id],
            $validatedData
        );

        $platformSyncData = [];

        foreach ($this->selectedPlatforms as $platformId => $active) {
            $platformSyncData[$platformId] = ['sales' => $this->platformSales[$platformId] ?? 0];
        }

        $game->platforms()->sync($platformSyncData);

        $characterSyncData = [];

        foreach ($this->selectedCharacters as $characterId => $active) {
            $characterSyncData[$characterId] = ['appearance' => $this->characterAppearance[$characterId] ?? now()];
        }

        $game->characters()->sync($characterSyncData);

        return redirect()->route('games')
            ->with('status', $this->game ? 'Juego actualizado correctamente' : 'Juego creado exitosamente');
    }

    public function render()
    {
        return view('livewire.game-form-fields');
    }

    private function handleImageUpload()
    {
        if ($this->image) {
            if ($this->game && $this->game->image_url) {
                Storage::disk('public')->delete($this->game->image_url);
            }
            return $this->image->store('images/games', 'public');
        }

        return $this->game->image_url ?? null;
    }
}
