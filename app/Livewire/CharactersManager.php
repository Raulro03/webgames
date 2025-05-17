<?php

namespace App\Livewire;

use App\Http\Requests\CharacterRequest;
use App\Models\Character;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CharactersManager extends Component
{
    use WithPagination, WithFileUploads;

    public $currentCharacter = null;
    public $name;
    public $age;
    public $description;
    public $image;
    public $imagePreview;
    public $isEditMode = false;
    public $ShowModal = false;
    public $FormModal = false;
    public $DeleteModal = false;
    public $confirmingDelete = false;

    public $games;
    public $gamesAppearance =[];

    protected function rules()
    {
        return (new CharacterRequest())->rules();
    }

    public function render()
    {
        if (!$this->games) {
            $this->games = Game::all();
        }

        return view('livewire.characters-manager', [
            'characters' => Character::query()->paginate(9)
        ]);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->age = '';
        $this->image = null;
        $this->imagePreview = null;
        $this->currentCharacter = null;
        $this->gamesAppearance = [];
    }

    public function create()
    {
        $this->resetFields();
        $this->isEditMode = false;
        $this->FormModal = true;
    }

    public function store()
    {
        $this->validate(
            $this->rules(),
            [],
            $this->attributes());

        $character = $this->fillCharacterData(new Character(),$this->handleImageUpload());
        $character->save();

        $gameSyncData = [];

        foreach ($this->gamesAppearance as $gameId=> $appearance) {
            $gameSyncData[$gameId] = ['appearance' => $this->gamesAppearance[$gameId] ?? 0];
        }

        $character->games()->sync($gameSyncData);

        $this->FormModal = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->currentCharacter = Character::findOrFail($id);

        $this->name = $this->currentCharacter->name;
        $this->description = $this->currentCharacter->description;
        $this->age = $this->currentCharacter->age;
        $this->imagePreview = $this->currentCharacter->image_url ? asset($this->currentCharacter->image_url) : null;

        foreach ($this->currentCharacter->games as $game) {
            $this->gamesAppearance[$game->id] = $game->pivot->appearance;
        }

        $this->isEditMode = true;
        $this->FormModal = true;
    }

    public function toggleGames($gameId)
    {
        if (isset($this->gamesAppearance[$gameId])) {
            unset($this->gamesAppearance[$gameId]);
        } else {
            $this->gamesAppearance[$gameId] = now();
        }
    }

    public function update()
    {
        $this->validate(
            $this->rules(),
            [],
            $this->attributes());

        $character = Character::findOrFail($this->currentCharacter->id);
        $character = $this->fillCharacterData($character,$this->handleImageUpload());
        $character->save();

        $gameSyncData = [];

        foreach ($this->gamesAppearance as $gameId => $appearance) {
            $gameSyncData[$gameId] = ['appearance' => $appearance];
        }

        $character->games()->sync($gameSyncData);

        $this->FormModal = false;
        $this->resetFields();
    }

    public function show($id)
    {
        $this->currentCharacter = Character::findOrFail($id);
        $this->ShowModal = true;
    }

    public function confirmDelete($id)
    {
        $this->currentCharacter = Character::findOrFail($id);
        $this->DeleteModal = true;
    }

    public function delete()
    {

        if ($this->currentCharacter->image_url) {
            Storage::disk('public')->delete($this->currentCharacter->image_url);
        }

        $this->currentCharacter->games()->detach();

        $this->currentCharacter->delete();
        $this->DeleteModal = false;
        $this->confirmingDelete = false;
        $this->resetFields();

    }

    public function closeModalCreateEdit()
    {
        $this->FormModal = false;
        $this->isEditMode = false;
        $this->resetFields();
    }

    private function handleImageUpload()
    {
        if ($this->image) {
            if ($this->currentCharacter && $this->currentCharacter->image_url) {
                Storage::disk('public')->delete($this->currentCharacter->image_url);
            }
            return $this->image->store('images/characters', 'public');
        }

        return $this->currentCharacter->image_url ?? null;
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

    private function fillCharacterData($character, $imagePath = null)
    {
        $character->name = $this->name;
        $character->description = $this->description;
        $character->age = $this->age;

        if ($imagePath) {
            $character->image_url = $imagePath;
        }

        return $character;
    }

    public function attributes()
    {
        $attributes = [];

        foreach ($this->gamesAppearance as $id => $value) {
            $game = $this->games->firstWhere('id', $id);
            $attributes["gamesAppearance.$id"] = $game ? "aparición de {$game->title}" : "aparición de personaje";
        }

        return $attributes;
    }
}
