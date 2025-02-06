<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" href="{{ asset('images/webgames.png') }}" type="image/png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WebGames</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <!-- Navbar -->
    <x-nav-bar>

    </x-nav-bar>

    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto mt-10 p-4 text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            ¡Bienvenido a WebGames!
        </h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
            Descubre y comparte tu pasión por los videojuegos.
        </p>
    </div>

    <!-- Footer -->
    <x-footer>

    </x-footer>

    </body>
</html>
