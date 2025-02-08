@extends('layouts.webgames')

@section('content')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

        <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">Contacto</h1>
        <p class="mt-4 text-gray-700 dark:text-gray-300 text-lg text-center">
            ¿Tienes preguntas o sugerencias? Estamos aquí para ayudarte. Contáctanos a través de los siguientes medios:
        </p>

        <div class="mt-6 space-y-4 text-gray-600 dark:text-gray-300 text-center">
            <p class="transition duration-300 transform hover:scale-105">
                📧 Correo: <span class="font-semibold text-purple-500">support@webgames.com</span>
            </p>
            <p class="transition duration-300 transform hover:scale-105">
                📞 Teléfono: <span class="font-semibold text-purple-500">+34 600 123 456</span>
            </p>
            <p class="transition duration-300 transform hover:scale-105">
                🕒 Horario: <span class="font-semibold text-purple-500">Lunes a Viernes - 9:00 AM a 6:00 PM</span>
            </p>
        </div>
    </div>
    </div>
    <!--<form action="/contact" method="POST" class="mt-8 space-y-6 w-full max-w-md mx-auto">
        @csrf
        <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <label for="name" class="sr-only">Nombre</label>
                <input id="name" name="name" type="text" autocomplete="name" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Nombre">
            </div>
            <div>
                <label for="email" class="sr-only">Correo Electrónico</label>
                <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Correo Electrónico">
            </div>
            <div>
                <label for="message" class="sr-only">Mensaje</label>
                <textarea id="message" name="message" rows="4" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Mensaje"></textarea>
            </div>
        </div>
        <div>
            <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Enviar
            </button>
        </div>
    </form>-->



@endsection
