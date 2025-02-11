@extends('layouts.webgames')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

            <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">{{ $character->name }}</h1>

            <div class="mt-6 flex flex-col md:flex-row items-center">
                <img src="{{ asset($character->image_url) }}" alt="{{ $character->name }}" class="w-64 h-64 object-cover rounded-lg shadow-md border border-gray-300">
                <div class="md:ml-6 mt-4 md:mt-0 text-gray-700 dark:text-gray-300">
                    <p><strong>Descripción:</strong> {{ $character->description }}</p>
                    <p><strong>Edad:</strong> {{ $character->age }} años</p>
                    @foreach($character->games as $game)
                        <div class="mt-4 p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
                            <a href="{{ route('games.show', $game->id) }}" class="text-lg font-semibold text-gray-800 dark:text-gray-200"><strong>Juego:</strong> {{ $game->title }}</a>
                            <p class="text-lg text-gray-600 dark:text-gray-400"><strong>Aparecio en:</strong> {{ $game->pivot->appearance ?? 'No aparece' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('characters') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Volver a la lista</a>
            </div>
        </div>
    </div>
@endsection
