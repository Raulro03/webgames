@extends('layouts.webgames')

@section('content')
    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto mt-10 p-6 text-center">
        <h1 class="text-5xl font-extrabold text-purple-600 dark:text-purple-400 animate-bounce">
            ¡Bienvenido a WebGames!
        </h1>
        <p class="mt-4 text-lg text-gray-700 dark:text-gray-300 animate-fade-in">
            Descubre y comparte tu pasión por los videojuegos. Explora juegos, personajes, plataformas y participa en nuestro foro y comparador de personajes.
        </p>
    </div>

    <!-- Secciones principales -->
    <div class="max-w-7xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        <!-- Juegos -->
        <a href="{{ route('games') }}" class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg text-center transform transition duration-500 hover:scale-110 hover:shadow-2xl">
            <h2 class="text-2xl font-bold">Juegos</h2>
            <p class="mt-2">Explora nuestra colección de videojuegos.</p>
        </a>

        <!-- Plataformas -->
        <a href="{{ route('platforms') }}" class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg text-center transform transition duration-500 hover:scale-110 hover:shadow-2xl">
            <h2 class="text-2xl font-bold">Plataformas</h2>
            <p class="mt-2">Descubre las mejores consolas y plataformas.</p>
        </a>

        <!-- Personajes -->
        <a href="{{ route('characters') }}" class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg text-center transform transition duration-500 hover:scale-110 hover:shadow-2xl">
            <h2 class="text-2xl font-bold">Personajes</h2>
            <p class="mt-2">Conoce a los personajes más icónicos.</p>
        </a>
    </div>

    <!-- Foro y Comparador -->
    <div class="max-w-7xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
        <!-- Foro -->
        <a href="{{ route('forum') }}" class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg text-center transform transition duration-500 hover:scale-110 hover:shadow-2xl animate-fade-in">
            <h2 class="text-2xl font-bold">Foro</h2>
            <p class="mt-2">Únete a la comunidad y comparte noticias y opiniones.</p>
        </a>

        <!-- Comparador de Personajes -->
        <a href="{{ route('versus') }}" class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg text-center transform transition duration-500 hover:scale-110 hover:shadow-2xl animate-fade-in">
            <h2 class="text-2xl font-bold">Versus</h2>
            <p class="mt-2">Compara personajes y descubre quién es el mejor.</p>
        </a>
    </div>
@endsection

