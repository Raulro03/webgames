<?php

namespace App\Livewire;

use App\Http\Requests\GameRequest;
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
    public $platformSales = [];

    public $characters;
    public $characterAppearance = [] ;

    protected function rules() {
        return (new GameRequest())->rules();
    }

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
                $this->platformSales[$platform->id] = $platform->pivot->sales;
            }
            foreach ($game->characters as $character) {
                $this->characterAppearance[$character->id] = $character->pivot->appearance;
            }
            $this->imagePreview = $game->image_url ? asset($game->image_url) : null;
        }
    }

    public function togglePlatform($platformId)
    {
        if (isset($this->platformSales[$platformId])) {
            unset($this->platformSales[$platformId]);
        } else {
            $this->platformSales[$platformId] = 0;
        }
    }

    public function toggleCharacter($characterId)
    {
        if (isset($this->characterAppearance[$characterId])) {
            unset($this->characterAppearance[$characterId]);
        } else {
            $this->characterAppearance[$characterId] = now();
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

        $validatedData = $this->validate(
            $this->rules(),
            [],
            $this->attributes());

        $validatedData['image_url'] = $this->handleImageUpload();

        $game = Game::updateOrCreate(
            ['id' => optional($this->game)->id],
            $validatedData
        );

        $platformSyncData = [];

        foreach ($this->platformSales as $platformId => $sales) {
            $platformSyncData[$platformId] = ['sales' => $sales ?? 0];
        }

        $game->platforms()->sync($platformSyncData);

        $characterSyncData = [];

        foreach ($this->characterAppearance as $characterId => $appearance) {
            $characterSyncData[$characterId] = ['appearance' => $appearance ?? now()];
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

    public function attributes()
    {
        $attributes = [];

        foreach ($this->platformSales as $id => $value) {
            $platform = $this->platforms->firstWhere('id', $id);
            $attributes["platformSales.$id"] = $platform ? "ventas de {$platform->name}" : "ventas de plataforma";
        }

        foreach ($this->characterAppearance as $id => $value) {
            $character = $this->characters->firstWhere('id', $id);
            $attributes["characterAppearance.$id"] = $character ? "aparición de {$character->name}" : "aparición de personaje";
        }

        return $attributes;
    }
}
