<div class="container mx-auto px-4">

    <div class="flex justify-between items-center my-6">
        <input
            type="text"
            wire:model.live.debounce.200ms="search"
            placeholder="Buscar juego..."
            class="px-4 py-2 border rounded-md w-1/2"
        >

        <button
            wire:click="toggleOrder"
            class="px-4 py-2 bg-purple-600 text-white rounded-md"
        >
            Ordenar por Rating: {{ $orderBy === 'desc' ? 'Descendente' : 'Ascendente' }}
        </button>
    </div>

        @if(isset($games) && $games->count() > 0)

        <div class="max-w-7xl mx-auto mt-10 p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($games as $game)

            <a href="{{ route('games.show', $game->id) }}" class="block dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
                <!-- Bloque de Juego -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <img src="{{$game->image_url}}" alt="Nombre del Juego" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{$game->title}} - Rating: {{$game->average_rating}}</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{Str::limit($game->description, 100)}}</p>
                        <div class="mt-4">
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">{{number_format($game->price / 100, 2, ',', '.')}}€</span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">No se han encontrado juegos</p>

        @endif


    <div class="mt-6">
        {{ $games->links() }}
    </div>
</div>
