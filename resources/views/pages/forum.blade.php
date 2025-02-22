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

    <div class="container mx-auto py-12 px-6">
        <h1 class="text-4xl font-extrabold text-purple-300 text-center mb-8">🎮 {{__('Video Game Forum')}}</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Sección de Juegos -->
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center gap-2">
                    🎮 {{__('Games')}}
                </h2>
                <p class="text-sm text-purple-200">{{__('Discuss the latest releases, analysis and recommendations.')}}</p>
                <a href="{{ route('forum.category', 'game') }}"
                   class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    {{__('See posts about Games')}} →
                </a>
            </div>

            <!-- Sección de Plataformas -->
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center gap-2">
                    🖥️ {{__('Platforms')}}
                </h2>
                <p class="text-sm text-purple-200">{{__('Share your thoughts on consoles, PC gaming and hardware.')}}</p>
                <a href="{{ route('forum.category', 'platform') }}"
                   class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    {{__('See posts about Platforms')}} →
                </a>
            </div>

            <!-- Sección de Personajes -->
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center gap-2">
                    🧙‍♂️ {{__('Character')}}
                </h2>
                <p class="text-sm text-purple-200">{{__('Discussions about the most iconic and powerful characters.')}}</p>
                <a href="{{ route('forum.category', 'character') }}"
                   class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    {{__('See posts about Characters')}} →
                </a>
            </div>
        </div>

        <!-- Sección de Categorías Generales -->
        <div class="mt-10 text-center">
            <h2 class="text-2xl font-bold text-purple-300 mb-4">📢 {{__('Other Topics')}}</h2>
            <div class="bg-purple-800 text-white shadow-md rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg inline-block">
                <a href="{{ route('forum.category', 'general') }}"
                   class="text-purple-300 hover:text-purple-100 font-medium text-lg">
                    {{__('See posts general')}} →
                </a>
            </div>
        </div>
    </div>
@endsection
