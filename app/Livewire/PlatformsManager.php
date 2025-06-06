<?php

namespace App\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\PlatformsRequest;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PlatformsManager extends Component
{
    use WithPagination, WithFileUploads, AuthorizesRequests;

    public $currentPlatform = null;
    public $name;
    public $description;
    public $release_date;
    public $price;
    public $average_rating;
    public $image;
    public $imagePreview;
    public $isEditMode = false;
    public $ShowModal = false;
    public $FormModal = false;
    public $DeleteModal = false;
    public $confirmingDelete = false;

    public $games;
    public $gamesSales =[];

    public $search = '';
    public $min_price;
    public $max_price;
    public $min_rating;
    public $max_rating;
    public $release_from;
    public $release_to;

    protected function rules()
    {
        return (new PlatformsRequest())->rules();
    }

    public function render()
    {
        if (!$this->games) {
            $this->games = Game::all();
        }

        $filters = [
            'search' => $this->search,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'min_rating' => $this->min_rating,
            'max_rating' => $this->max_rating,
            'release_from' => $this->release_from,
            'release_to' => $this->release_to,
        ];

        return view('livewire.platforms-manager', [
            'platforms' => Platform::filterPlatform($filters)->paginate(9),
        ]);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->release_date = '';
        $this->price = '';
        $this->average_rating = '';
        $this->image = null;
        $this->imagePreview = null;
        $this->currentPlatform = null;
        $this->gamesSales = [];
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->min_price = null;
        $this->max_price = null;
        $this->min_rating = null;
        $this->max_rating = null;
        $this->release_from = null;
        $this->release_to = null;
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function create()
    {

        $this->authorize('create', Platform::class);

        $this->resetFields();
        $this->isEditMode = false;
        $this->FormModal = true;
    }

    public function store()
    {
        $this->authorize('create', Platform::class);

        $this->validate();

        $platform = $this->fillPlatformData(new Platform(),$this->handleImageUpload());
        $platform->save();

        $gameSyncData = [];

        foreach ($this->gamesSales as $gameId=> $sales) {
            $gameSyncData[$gameId] = ['sales' => $this->gamesSales[$gameId] ?? 0];
        }

        $platform->games()->sync($gameSyncData);

        $this->FormModal = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->currentPlatform = Platform::findOrFail($id);

        $this->authorize('update', $this->currentPlatform);

        $this->name = $this->currentPlatform->name;
        $this->description = $this->currentPlatform->description;
        $this->release_date = $this->currentPlatform->release_date;
        $this->price = $this->currentPlatform->price;
        $this->average_rating = $this->currentPlatform->average_rating;
        $this->imagePreview = $this->currentPlatform->image_url ? asset($this->currentPlatform->image_url) : null;

        foreach ($this->currentPlatform->games as $game) {
            $this->gamesSales[$game->id] = $game->pivot->sales;
        }

        $this->isEditMode = true;
        $this->FormModal = true;
    }

    public function toggleGames($gameId)
    {
        if (isset($this->gamesSales[$gameId])) {
            unset($this->gamesSales[$gameId]);
        } else {
            $this->gamesSales[$gameId] = 0;
        }
    }

    public function update()
    {

        $this->authorize('update', $this->currentPlatform);

        $this->validate();

        $platform = $this->fillPlatformData($this->currentPlatform,$this->handleImageUpload());
        $platform->save();

        $gameSyncData = [];

        foreach ($this->gamesSales as $gameId => $sales) {
            $gameSyncData[$gameId] = ['sales' => $sales ?? 0];
        }

        $platform->games()->sync($gameSyncData);



        $this->FormModal = false;
        $this->resetFields();
    }

    public function show($id)
    {
        $this->currentPlatform = Platform::findOrFail($id);
        $this->ShowModal = true;
    }

    public function confirmDelete($id)
    {
        $this->currentPlatform = Platform::findOrFail($id);

        $this->authorize('delete', $this->currentPlatform);

        $this->DeleteModal = true;
    }

    public function delete()
    {
        $this->authorize('delete', $this->currentPlatform);

        if ($this->currentPlatform->image_url) {
            Storage::disk('public')->delete($this->currentPlatform->image_url);
        }

        $this->currentPlatform->games()->detach();

        $this->currentPlatform->delete();
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
            if ($this->currentPlatform && $this->currentPlatform->image_url) {
                Storage::disk('public')->delete($this->currentPlatform->image_url);
            }
            return $this->image->store('images/platforms', 'public');
        }

        return $this->currentPlatform->image_url ?? null;
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

    private function fillPlatformData($platform, $imagePath = null)
    {
        $platform->name = $this->name;
        $platform->description = $this->description;
        $platform->release_date = $this->release_date;
        $platform->price = $this->price;
        $platform->average_rating = $this->average_rating;

        if ($imagePath) {
            $platform->image_url = $imagePath;
        }

        return $platform;
    }
}

