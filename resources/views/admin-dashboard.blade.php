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
                <x-request-forbidden-word/>
                <x-welcome :stats="$stats" />
                <x-button-generate-pdf/>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="text-4xl font-extrabold text-purple-600 text-center mb-4 pt-4">{{__('Dashboard Admin')}}</h2>
                @if(session('status'))
                    <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="mb-2 text-white bg-violet-800 transition-opacity duration-500 ease-in-out animate-fade-in">{{ session('status') }}</p>
                @endif
                <div class="flex space-x-4">
                    <form action="{{ route('dashboard.deleteArchivedPosts') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 mb-2">
                            🗑️ {{__('Delete Archived Posts Older than 5 Years')}}
                        </button>
                    </form>
                    <form action="{{ route('dashboard.CleanTrashedPosts') }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar los posts archivados?')">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                            🗑️ {{__('Clean trash')}}
                        </button>
                    </form>
                    <form action="{{ route('admin.users') }}" method="GET">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-2">
                            👤 {{__('Watch User')}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-6 bg-white dark:bg-gray-800 p-4 rounded-lg">
            <h3 class="text-2xl text-purple-600 font-semibold mb-4">{{__('Requests for Forbidden Words')}}</h3>

            @foreach($stats['words'] as $word)
                <div class="flex justify-between items-center mb-3 bg-gray-100 p-3 rounded dark:bg-gray-900">
                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $word->word }}</span>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.forbidden-words.manage', $word->id) }}">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                ✅ {{__('Accept')}}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.forbidden-words.manage', $word->id) }}">
                            @csrf
                            <input type="hidden" name="action" value="decline">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                ❌ {{__('Declined')}}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
