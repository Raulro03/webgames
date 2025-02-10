<?php

namespace App\Livewire;

use App\Services\IGDBService;
use Livewire\Component;

class TopPlatforms extends Component
{
    public $platforms;

    public function mount(IGDBService $igdbService)
    {
        $this->platforms = $igdbService->getTopPlatformsByPopularity(10);
    }

    public function render()
    {
        return view('livewire.top-platforms')->extends('layouts.webgames')->section('content');
    }
}
