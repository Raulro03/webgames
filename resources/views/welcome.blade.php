<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WebGames</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <!-- Barra de Navegación -->
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20"> <!-- Aumenté la altura a h-20 -->
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('images/webgames.png') }}" alt="WebGames Logo" class="h-[70px] mr-2 rounded-2xl"> <!-- Ajusta el tamaño de la imagen aquí -->
                    <a href="/" class="text-white text-lg font-bold">
                        WebGames
                    </a>
                </div>
                <!-- Links de navegación -->
                <div class="hidden md:flex space-x-4">
                    <a href="#home" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                    <a href="#console" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Consolas</a>
                    <a href="#games" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Juegos</a>
                    <a href="#characters" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Personajes</a>
                    <a href="#forum" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Foro</a>
                </div>
            </div>
        </div>
    </nav>

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
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Información básica -->
                <div>
                    <h5 class="text-lg font-bold text-white">WebGames</h5>
                    <p class="text-sm text-gray-400">
                        © 2025 WebGames. Todos los derechos reservados.
                    </p>
                </div>

                <!-- Redes sociales -->
                <div class="flex justify-center mt-4 space-x-6">
                    <a href="#" class="hover:text-white" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.675 0H1.326C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.326 24h11.495v-9.294H9.691v-3.622h3.13V8.411c0-3.1 1.893-4.789 4.655-4.789 1.325 0 2.462.099 2.794.143v3.24h-1.918c-1.506 0-1.797.716-1.797 1.766v2.315h3.59l-.467 3.622h-3.123V24h6.116c.732 0 1.325-.593 1.325-1.326V1.326C24 .593 23.407 0 22.675 0z"/></svg>
                    </a>
                    <a href="#" class="hover:text-white" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 4.556a9.934 9.934 0 0 1-2.828.775A4.932 4.932 0 0 0 23.337 3.1a9.869 9.869 0 0 1-3.127 1.195 4.916 4.916 0 0 0-8.375 4.482A13.937 13.937 0 0 1 1.671 3.149 4.822 4.822 0 0 0 3.162 9.75a4.903 4.903 0 0 1-2.224-.616v.061a4.917 4.917 0 0 0 3.946 4.827 4.933 4.933 0 0 1-2.217.084 4.92 4.92 0 0 0 4.588 3.417A9.868 9.868 0 0 1 0 19.54a13.94 13.94 0 0 0 7.548 2.212c9.051 0 14.001-7.496 14.001-13.986 0-.213-.005-.425-.014-.636A9.936 9.936 0 0 0 24 4.556z"/></svg>
                    </a>
                    <a href="#" class="hover:text-white" aria-label="GitHub">
                        <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.166 6.839 9.49.5.092.683-.217.683-.482 0-.237-.008-.868-.013-1.703-2.782.604-3.369-1.342-3.369-1.342-.454-1.154-1.11-1.461-1.11-1.461-.908-.62.069-.608.069-.608 1.003.07 1.531 1.031 1.531 1.031.892 1.529 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.112-4.555-4.951 0-1.093.39-1.987 1.031-2.686-.103-.253-.447-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0 1 12 6.844c.851.004 1.705.115 2.503.337 1.908-1.294 2.747-1.025 2.747-1.025.547 1.377.203 2.394.1 2.647.643.7 1.03 1.593 1.03 2.686 0 3.847-2.339 4.694-4.566 4.941.36.31.68.923.68 1.86 0 1.344-.012 2.427-.012 2.755 0 .268.18.578.688.48A10.004 10.004 0 0 0 22 12c0-5.523-4.477-10-10-10z" />
                        </svg>
                    </a>
                </div>

                <!-- Links rápidos -->
                <div class="flex space-x-4">
                    <a href="#about" class="hover:text-white text-sm">Acerca de</a>
                    <a href="#privacy" class="hover:text-white text-sm">Política de privacidad</a>
                    <a href="#contact" class="hover:text-white text-sm">Contacto</a>
                </div>
            </div>


        </div>
    </footer>
    </body>
</html>
