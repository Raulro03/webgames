@extends('layouts.webgames')

@section('content')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

            <div class="flex justify-center mb-6">
                <x-authentication-card-logo class="w-16 h-16" />
            </div>

            <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">Acerca de WebGames</h1>
            <p class="mt-4 text-gray-700 dark:text-gray-300 text-lg text-center">
                Bienvenido a <span class="font-semibold text-purple-500">WebGames</span>, tu fuente número uno para todo lo relacionado con los videojuegos. Nos apasiona ofrecerte la mejor experiencia gamer con énfasis en calidad, interactividad y comunidad.
            </p>

            <div class="mt-6 space-y-4 text-gray-600 dark:text-gray-300">
                <p class="transition duration-300 transform hover:scale-105">
                    Desde nuestros inicios en 2023, hemos evolucionado constantemente para ofrecer una plataforma que conecta jugadores, proporciona información actualizada sobre videojuegos y permite a la comunidad compartir sus experiencias.
                </p>

                <p class="transition duration-300 transform hover:scale-105">
                    En WebGames, puedes descubrir nuevos títulos, comparar personajes según sus estadísticas y compartir tus opiniones en nuestro mini foro. Además, te damos la posibilidad de crear tu propia biblioteca de juegos favoritos.
                </p>

                <p class="transition duration-300 transform hover:scale-105">
                    Nuestro objetivo es construir una comunidad gamer vibrante y participativa, donde cada usuario pueda sentirse parte de algo más grande. Nos encanta lo que hacemos y esperamos que disfrutes de nuestra plataforma tanto como nosotros disfrutamos desarrollándola.
                </p>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-700 dark:text-gray-300 font-semibold">Si tienes alguna pregunta o comentario, no dudes en ponerte en contacto con nosotros.</p>
                <p class="text-purple-500 font-bold text-lg mt-2">¡Gracias por ser parte de WebGames!</p>
            </div>
        </div>
    </div>


@endsection

