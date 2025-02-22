@extends('layouts.webgames')

@section('content')

    <div class="flex justify-end mt-4">
        <a href="{{ route('top-games') }}" class=" mr-2 bg-purple-600 text-white px-4 py-2 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:bg-purple-700">
            {{__('See Most Popular Games of')}} IGDB
        </a>
    </div>

    <livewire:game-search />

@endsection
