@extends('layouts.webgames')

@section('content')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

        <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">Contacto</h1>
        <p class="mt-4 text-gray-700 dark:text-gray-300 text-lg text-center">
            {{__('Do you have questions or suggestions? We are here to help you. Contact us through the following means:')}}
        </p>

        <div class="mt-6 space-y-4 text-gray-600 dark:text-gray-300 text-center">
            <p class="transition duration-300 transform hover:scale-105">
                📧 {{__('Email')}}: <span class="font-semibold text-purple-500">support@webgames.com</span>
            </p>
            <p class="transition duration-300 transform hover:scale-105">
                📞 {{__('Phone')}}: <span class="font-semibold text-purple-500">+34 600 123 456</span>
            </p>
            <p class="transition duration-300 transform hover:scale-105">
                🕒 {{__('Schedule')}}: <span class="font-semibold text-purple-500">Lunes a Viernes - 9:00 AM a 6:00 PM</span>
            </p>
        </div>
    </div>
    </div>
@endsection
