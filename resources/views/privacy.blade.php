@extends('layouts.webgames')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Privacy Policy Section -->
    <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative mb-12">
        <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

        <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">Política de Privacidad</h1>
        <p class="mt-4 text-gray-700 dark:text-gray-300 text-lg text-center">
            En <span class="font-semibold text-purple-500">WebGames</span>, tu privacidad es nuestra prioridad. Aseguramos la protección de tus datos y el uso responsable de la información.
        </p>

        <div class="mt-6 space-y-4 text-gray-600 dark:text-gray-300">
            <p class="transition duration-300 transform hover:scale-105">
                Recopilamos información mínima para mejorar tu experiencia y ofrecerte contenido relevante. Nunca compartimos tus datos sin tu consentimiento.
            </p>
            <p class="transition duration-300 transform hover:scale-105">
                Puedes gestionar tus preferencias de privacidad en la configuración de tu cuenta.
            </p>
            <p class="transition duration-300 transform hover:scale-105">
                Para más información, revisa nuestra política completa o contáctanos si tienes dudas.
            </p>
        </div>
    </div>
</div>
@endsection
