@extends('layouts.webgames')

@section('content')

<!-- Personajes -->

<div class="max-w-7xl mx-auto mt-10 p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">º
    <!-- Bloque de Personajes -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <img src="URL_DE_LA_IMAGEN_DEL_personaje" alt="Nombre del Personaje" class="w-full h-48 object-cover">
        <div class="p-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Nombre Del Personaje</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Descripción del personaje. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </div>
    <!-- Repite el bloque de juego para cada juego -->
</div>
@endsection
