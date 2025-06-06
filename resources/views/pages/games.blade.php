@extends('layouts.webgames')

@section('content')
    @if (session('status'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             class="container mx-auto p-4">
            <div class="bg-green-600 text-white p-4 rounded-lg shadow-md text-center transition-opacity duration-500 ease-in-out animate-fade-in">
                <p>{{ session('status') }}</p>
            </div>
        </div>
    @endif
    <div class="flex justify-end mt-4 mr-4 space-x-2">
        <a href="{{ route('top-games') }}" class=" mr-2 bg-purple-600 text-white px-4 py-2 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:bg-purple-700">
            {{__('See Most Popular Games of')}} IGDB
        </a>
        @can('create', \App\Models\Game::class)
        <a href="{{ route('games.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:bg-purple-700">
            {{__('Create New Game')}}
        </a>
        @endcan
    </div>

    <livewire:game-search />

@endsection
