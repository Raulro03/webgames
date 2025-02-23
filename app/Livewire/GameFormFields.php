<?php

namespace App\Livewire;

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

    protected $rules = [
        'title' => 'required|string|min:10|max:255',
        'description' => 'nullable|string',
        'release_date' => 'required|date',
        'average_rating' => 'nullable|numeric|between:0,9.99',
        'price' => 'required|integer|max:999999',
        'developer_id' => 'required',
        'image' => 'nullable|image',
    ];

    public function mount($game = null)
    {
        $this->developers = Developer::all();

        if ($game) {
            $this->title = $game->title;
            $this->description = $game->description;
            $this->price = $game->price;
            $this->release_date = optional($game->release_date)->format('Y-m-d');
            $this->average_rating = $game->average_rating;
            $this->developer_id = $game->developer_id;
            $this->imagePreview = $game->image_url ? asset('storage/' . $game->image_url) : null;
        }
    }

    public function updatedImage()
    {
        $this->validate(['image' => 'image|max:2048']);

        try {
            $this->imagePreview = $this->image->temporaryUrl();
        } catch (\Exception $e) {
            $this->addError('image', 'No se pudo cargar la vista previa.');
        }
    }

    public function save()
    {

        $validatedData = $this->validate();

        $validatedData['image_url'] = $this->handleImageUpload();

        Game::updateOrCreate(
            ['id' => optional($this->game)->id],
            $validatedData
        );


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
