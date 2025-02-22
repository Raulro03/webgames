<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-4xl font-bold text-purple-600 text-center mb-6">{{ __('Character Comparator') }}</h1>

    <!-- Contenedor de personajes -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($characters as $character)
            <div wire:click="selectCharacter({{ $character->id }})"
                 class="cursor-pointer border-2 border-purple-500 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 text-center transition-all duration-300 transform hover:scale-110 hover:border-purple-400 hover:shadow-lg">
                <div class="relative group">
                    <img src="{{ asset($character->image_url) }}"
                         alt="{{ $character->name }}"
                         class="w-24 h-24 mx-auto object-cover rounded-md transition-all duration-300 group-hover:brightness-125">
                    <h2 class="text-md font-semibold mt-2 text-gray-900 dark:text-gray-200">{{ $character->name }}</h2>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Sección de resultado cuando hay 2 personajes seleccionados -->
    @if(count($selectedCharacters) == 2)
        <div class="m-6 p-6 bg-gray-800 text-white rounded-lg shadow-md text-center animate-fade-in">
            <h2 class="text-xl font-bold mb-4">{{__('Results of Versus')}}</h2>

            <div class="flex justify-center gap-8 items-center">
                @foreach($selectedCharacters as $character)
                    <div class="text-center transition-transform duration-500 transform scale-90">
                        <img src="{{ asset($character->image_url) }}"
                             alt="{{ $character->name }}"
                             class="w-20 h-20 object-cover rounded-md border-2 border-white">
                        <h3 class="mt-2 font-bold">{{ $character->name }}</h3>
                        <p class="text-sm">💪 {{ __('Constitution') }}: {{ $character->statistics->constitution }}</p>
                        <p class="text-sm">🔥 {{ __('Strength') }}: {{ $character->statistics->strength }}</p>
                        <p class="text-sm">⚡ {{ __('Agility') }}: {{ $character->statistics->agility }}</p>
                        <p class="text-sm">🧠 {{ __('Intelligence') }}: {{ $character->statistics->intelligence }}</p>
                        <p class="text-sm">✨ {{ __('Charisma') }}: {{ $character->statistics->charisma }}</p>

                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-bold text-yellow-400 animate-pulse">🏆 {{__('Winner')}}: {{ is_object($winner) ? $winner->name : $winner }}</h3>
            </div>

            <button wire:click="resetSelection"
                    class="mt-6 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg shadow-md transition-all duration-300 animate-bounce">
                {{__("Back to Compare")}}
            </button>
        </div>
    @endif

</div>
