@extends('layouts.webgames')

@section('content')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-purple-500 relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

            <div class="flex justify-center mb-6">
                <x-authentication-card-logo class="w-16 h-16" />
            </div>

            <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400">{{ __('about.title') }}</h1>
            <p class="mt-4 text-gray-700 dark:text-gray-300 text-lg text-center">
                {{ __('about.intro') }}
            </p>

            <div class="mt-6 space-y-4 text-gray-600 dark:text-gray-300">
                <p class="transition duration-300 transform hover:scale-105">
                    {{ __('about.history') }}
                </p>

                <p class="transition duration-300 transform hover:scale-105">
                    {{ __('about.features') }}
                </p>

                <p class="transition duration-300 transform hover:scale-105">
                    {{ __('about.mission') }}
                </p>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-700 dark:text-gray-300 font-semibold">{{ __('about.contact') }}</p>
                <p class="text-purple-500 font-bold text-lg mt-2">{{ __('about.thanks') }}</p>
            </div>
        </div>
    </div>


@endsection

