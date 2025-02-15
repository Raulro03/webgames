
<div class="max-w-5xl mx-auto mt-10">
    <h1 class="text-3xl font-bold text-purple-600 text-center">Juegos Más Populares</h1>

    <div class="flex justify-end mt-4">
        <a href="{{ route('games') }}" class="mr-2 bg-purple-600 text-white px-4 py-2 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:bg-blue-700">
            Volver a Juegos
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-6">
        @foreach($games as $game)
            @if($game)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center transform transition duration-300 hover:scale-105">
                    <img src="{{ $game['cover']['url'] ?? 'https://via.placeholder.com/150' }}" alt="{{ $game['name'] }}" class="w-full h-40 object-cover rounded-md">
                    <a href="{{$game['url']}}" target="_blank"><h2 class="text-lg font-bold mt-2 text-purple-600">{{ $game['name'] }}</h2></a>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Rating: {{ $game['rating'] ?? 'N/A' }}</p>
                </div>
            @endif
        @endforeach
    </div>

    <div class="flex justify-center space-x-4 m-4">
        @if(count($games) > 10)
            <button wire:click="loadLess" class="px-4 py-2 bg-blue-300 text-white rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:bg-blue-500">
                Mostrar menos
            </button>
        @endif

        <button wire:click="loadMore" class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:bg-purple-700">
            Mostrar 10 más
        </button>
    </div>
</div>

