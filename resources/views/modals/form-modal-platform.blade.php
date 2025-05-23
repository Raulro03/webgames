<x-dialog-modal wire:model="FormModal" maxWidth="2xl">
    <x-slot name="title">
        {{ $isEditMode ? __("Edit Platform") : __('Create Platform') }}
    </x-slot>

    <x-slot name="content">
        {{-- Nombre --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__("Name")}}</label>
            <input wire:model="name" type="text"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__("Description")}}</label>
            <textarea wire:model="description"
                      class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                      rows="3"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Fecha de lanzamiento --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__("Release Date")}}</label>
            <input wire:model="release_date" type="date"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('release_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Precio --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__("Price")}} (€)</label>
            <input wire:model="price" type="number" step="1" min="0"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Rating medio --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__("Average rating")}}</label>
            <input wire:model="average_rating" type="number" step="0.01" max="9.99"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('average_rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Juegos --}}
        <div class="mb-4 w-full max-h-64 overflow-y-auto border p-2 rounded">
            <label class="block text-gray-700 font-semibold mb-2">{{ __('Games') }}</label>
            @foreach ($games as $game)
                <div class="flex items-center space-x-4 mb-2">
                    <input type="checkbox"
                           wire:click="toggleGames({{ $game->id }})"
                           @if(isset($gamesSales[$game->id])) checked @endif
                    >
                    <label>{{ $game->title }}</label>

                    @if(isset($gamesSales[$game->id]))
                        <input type="number"
                               wire:model.defer="gamesSales.{{ $game->id }}"
                               placeholder="Ventas"
                               class="border rounded px-2 py-1 w-32"
                               min="0"
                        >
                        @error("gamesSales.$game->id")
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Imagen --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{ __('Platform Image') }}</label>
            <x-drag-and-drop :imagePreview="$imagePreview" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="closeModalCreateEdit">{{ __('Cancel') }}</x-secondary-button>
        <x-button wire:click="{{ $isEditMode ? 'update' : 'store' }}">
            {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
        </x-button>
    </x-slot>
</x-dialog-modal>
