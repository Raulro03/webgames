@extends('layouts.webgames')

@section('content')

    <div class="max-w-7xl mx-auto mt-10 p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Juegos -->
    @foreach($games as $game)

            <a href="{{ route('games.show', $game->id) }}" class="block dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
            <!-- Bloque de Juego -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <img src="{{$game->image_url}}" alt="Nombre del Juego" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{$game->title}}</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{Str::limit($game->description, 100)}}</p>
                    <div class="mt-4">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{number_format($game->price / 100, 2, ',', '.')}}€</span>
                    </div>
                </div>
            </div>

    @endforeach
    </div>
@endsection
