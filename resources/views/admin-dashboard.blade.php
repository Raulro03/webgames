<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('dashboard.deleteArchivedPosts') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 mb-2">
                        🗑️ Eliminar Posts Archivados de +5 Años
                    </button>
                </form>

                @if(session('status'))
                    <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="mb-2 text-white bg-violet-800 transition-opacity duration-500 ease-in-out animate-fade-in">{{ session('status') }}</p>
                @endif
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
