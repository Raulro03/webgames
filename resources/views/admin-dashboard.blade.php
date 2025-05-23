<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-button-generate-token/>
                <x-welcome :stats="$stats" />
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="text-4xl font-extrabold text-purple-600 text-center mb-4 pt-4">Panel del Admin</h2>
                @if(session('status'))
                    <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="mb-2 text-white bg-violet-800 transition-opacity duration-500 ease-in-out animate-fade-in">{{ session('status') }}</p>
                @endif
                <div class="flex space-x-4">
                    <form action="{{ route('dashboard.deleteArchivedPosts') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 mb-2">
                            🗑️ Eliminar Posts Archivados de +5 Años
                        </button>
                    </form>
                    <form action="{{ route('dashboard.CleanTrashedPosts') }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar los posts archivados?')">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                            🗑️ Limpiar Papelera
                        </button>
                    </form>
                    <form action="{{ route('admin.users') }}" method="GET">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-2">
                            👤 Ver Usuarios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
