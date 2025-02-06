@extends('layouts.webgames')

@section('content')
    <!-- Contenido del foro aquí -->

    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Foro</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Bienvenido al foro de WebGames. Aquí podrás discutir sobre tus juegos favoritos, compartir trucos y mucho más.</p>
    </div>
    <div class="max-w-7xl mx-auto mt-10 p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Bloque de Tema -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <img src="URL_DE_LA_IMAGEN_DEL_TEMA" alt="Nombre del Tema" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Título del Tema</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Descripción del tema. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <div class="mt-4">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Autor del Tema</span>
                </div>
            </div>
        </div>
    </div>

        <!-- Repite el bloque de tema para cada tema -->
@endsection
