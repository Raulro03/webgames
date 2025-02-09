@extends('layouts.webgames')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Game Show Section -->
        <div class="max-w-4xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

            <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">{{ $game->title }}</h1>

            <div class="mt-6 flex flex-col md:flex-row items-center">
                <img src="{{ asset($game->image_url) }}" alt="{{ $game->title }}" class="w-64 h-64 object-cover rounded-lg shadow-md border border-gray-300">
                <div class="md:ml-6 mt-4 md:mt-0 text-gray-700 dark:text-gray-300">
                    <p><strong>Desarrollador:</strong> {{ $game->developer->name }}</p>
                    <p><strong>Plataformas:</strong> {{ $game->platforms->pluck('name')->join(', ') }}</p>
                    <p><strong>Categorías:</strong> {{ $game->categories->pluck('name')->join(', ') }}</p>
                    <p><strong>Descripción:</strong> {{ $game->description }}</p>
                    <p><strong>Precio:</strong> {{ $game->price / 100 }}€</p>
                    <p><strong>Calificaion promedio:</strong> {{ $game->average_rating }}</p>
                    <p><strong>Fecha de lanzamiento:</strong> {{ $game->release_date->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('games') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Volver a la lista</a>
            </div>
        </div>
    </div>
@endsection


