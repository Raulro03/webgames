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

    public $constitution;
    public $strength;
    public $agility;
    public $intelligence;
    public $charisma;

    public $search = '';
    public $min_age;
    public $max_age;
    public $min_constitution;
    public $min_strength;
    public $min_agility;
    public $min_intelligence;
    public $min_charisma;

    protected function rules()
    {
        return (new CharacterRequest())->rules();
    }

    public function render()
    {
        if (!$this->games) {
            $this->games = Game::all();
        }

        $filters = [
            'search' => $this->search,
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
            'min_constitution' => $this->min_constitution,
            'min_strength' => $this->min_strength,
            'min_agility' => $this->min_agility,
            'min_intelligence' => $this->min_intelligence,
            'min_charisma' => $this->min_charisma,
        ];

        return view('livewire.characters-manager', [
            'characters' => Character::with('statistics')->filterCharacter($filters)->paginate(9)
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
        $this->constitution = null;
        $this->strength = null;
        $this->agility = null;
        $this->intelligence = null;
        $this->charisma = null;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->min_age = null;
        $this->max_age = null;
        $this->min_constitution = null;
        $this->min_strength = null;
        $this->min_agility = null;
        $this->min_intelligence = null;
        $this->min_charisma = null;
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->authorize('create', Character::class);

        $this->resetFields();
        $this->isEditMode = false;
        $this->FormModal = true;
    }

    public function store()
    {
        $this->authorize('create', Character::class);

        $this->validate(
            $this->rules(),
            [],
            $this->attributes());

        $character = $this->fillCharacterData(new Character(),$this->handleImageUpload());
        $character->save();

        $character->statistics()->create([
            'constitution' => $this->constitution,
            'strength' => $this->strength,
            'agility' => $this->agility,
            'intelligence' => $this->intelligence,
            'charisma' => $this->charisma,
        ]);


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

        $this->authorize('update', Character::class);

        $this->name = $this->currentCharacter->name;
        $this->description = $this->currentCharacter->description;
        $this->age = $this->currentCharacter->age;
        $this->imagePreview = $this->currentCharacter->image_url ? asset($this->currentCharacter->image_url) : null;

        if ($this->currentCharacter->statistics) {
            $this->constitution = $this->currentCharacter->statistics->constitution;
            $this->strength = $this->currentCharacter->statistics->strength;
            $this->agility = $this->currentCharacter->statistics->agility;
            $this->intelligence = $this->currentCharacter->statistics->intelligence;
            $this->charisma = $this->currentCharacter->statistics->charisma;
        }

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

        $this->authorize('update', Character::class);

        $this->validate(
            $this->rules(),
            [],
            $this->attributes());

        $character = $this->fillCharacterData($this->currentCharacter,$this->handleImageUpload());
        $character->save();

        $this->currentCharacter->statistics()->updateOrCreate(
            ['character_id' => $this->currentCharacter->id],
            [
                'constitution' => $this->constitution,
                'strength' => $this->strength,
                'agility' => $this->agility,
                'intelligence' => $this->intelligence,
                'charisma' => $this->charisma,
            ]
        );

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
        $this->authorize('delete', Character::class);
        $this->DeleteModal = true;
    }

    public function delete()
    {
        $this->authorize('delete', Character::class);

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
