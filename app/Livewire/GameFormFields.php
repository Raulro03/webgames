<?php

namespace App\Livewire;

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
    public $sales = [];

    protected $rules = [
        'title' => 'required|string|min:10|max:255',
        'description' => 'nullable|string',
        'release_date' => 'required|date',
        'average_rating' => 'nullable|numeric|between:0,9.99',
        'price' => 'required|integer|max:999999',
        'developer_id' => 'required',
        'selectedPlatforms' => 'nullable|array',
        'selectedPlatforms.*' => 'required|integer|min:0',
        'image' => 'nullable|image',
    ];

    public function mount($game = null)
    {
        $this->platforms = Platform::all();
        $this->developers = Developer::all();

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
            $this->imagePreview = $game->image_url ? asset('storage/' . $game->image_url) : null;
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

        foreach ($this->selectedPlatforms as $platformId => $selected) {
            if ($selected) {
                $sales = $this->sales[$platformId] ?? 0;
                $game->platforms()->attach($platformId, ['sales' => $sales]);
            }
        }

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
