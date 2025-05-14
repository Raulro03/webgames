@extends('layouts.webgames')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

        <div class="max-w-4xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

            <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">{{ $game->title }}</h1>

            <div class="mt-6 flex flex-col md:flex-row items-center">
                <img src="{{ asset($game->image_url) }}" alt="{{ $game->title }}" class="w-64 h-64 object-cover rounded-lg shadow-md border border-gray-300">
                <div class="md:ml-6 mt-4 md:mt-0 text-gray-700 dark:text-gray-300">
                    <p><strong>{{__('Developer')}}:</strong> {{ $game->developer->name }}</p>
                    <p><strong>{{__('Category')}}:</strong> {{ $game->categories->pluck('name')->join(', ') }}</p>
                    <p><strong>{{__('Description')}}:</strong> {{ $game->description }}</p>
                    <p><strong>{{__('Price')}}:</strong> {{ number_format($game->price / 100, 2, ',', '.') }}€</p>
                    <p><strong>{{__('Average rating')}}:</strong> {{ $game->average_rating }}</p>
                    <p><strong>{{__('Release Date')}}:</strong> {{ $game->release_date->format('d/m/Y') }}</p>
                    @foreach($game->platforms as $platform)
                        <div class="mt-4 p-4 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md">
                            <a href="{{ route('platforms') }}" class="text-lg font-semibold text-gray-800 dark:text-gray-200"><strong>{{__('Platform')}}:</strong> {{ $platform->name }}</a>
                            <p class="text-lg text-gray-600 dark:text-gray-400"><strong>{{__('Sales')}}:</strong> {{ $platform->pivot->sales ?? 'No disponible' }} Unidades</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('games') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">{{__('Back to list')}}</a>
                <a href="{{ route('games.edit', $game->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ml-2">{{__('Edit')}}</a>
                <form action="{{ route('games.destroy', $game->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ml-2">{{__('Delete')}}</button>
                </form>
            </div>

            <x-download-pdf-button route="game.pdf" :id="$game->id" />
        </div>
    </div>
@endsection


