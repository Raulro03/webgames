@extends('layouts.webgames')

@section('content')
    <div class="container mx-auto py-12 px-6">
        <h1 class="text-4xl font-extrabold text-purple-300 text-center mb-8">🎮 Foro de Videojuegos</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Sección de Juegos -->
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center gap-2">
                    🎮 Juegos
                </h2>
                <p class="text-sm text-purple-200">Discute sobre los últimos lanzamientos, análisis y recomendaciones.</p>
                <a href="{{ route('forum.category', 'game') }}"
                   class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    Ver posts sobre Juegos →
                </a>
            </div>

            <!-- Sección de Plataformas -->
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center gap-2">
                    🖥️ Plataformas
                </h2>
                <p class="text-sm text-purple-200">Comparte opiniones sobre consolas, PC gaming y hardware.</p>
                <a href="{{ route('forum.category', 'platform') }}"
                   class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    Ver posts sobre Plataformas →
                </a>
            </div>

            <!-- Sección de Personajes -->
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center gap-2">
                    🧙‍♂️ Personajes
                </h2>
                <p class="text-sm text-purple-200">Debates sobre los personajes más icónicos y poderosos.</p>
                <a href="{{ route('forum.category', 'character') }}"
                   class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    Ver posts sobre Personajes →
                </a>
            </div>
        </div>

        <!-- Sección de Categorías Generales -->
        <div class="mt-10 text-center">
            <h2 class="text-2xl font-bold text-purple-300 mb-4">📢 Otros Temas</h2>
            <div class="bg-purple-800 text-white shadow-md rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg inline-block">
                <a href="{{ route('forum.category', 'general') }}"
                   class="text-purple-300 hover:text-purple-100 font-medium text-lg">
                    Ver posts generales →
                </a>
            </div>
        </div>
    </div>
@endsection
