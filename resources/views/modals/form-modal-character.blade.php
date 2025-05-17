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

        {{-- Edad --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__("Age")}}</label>
            <input wire:model="age" type="number" step="1" min="0"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Juegos --}}
        <div class="mb-4 w-full max-h-64 overflow-y-auto border p-2 rounded">
            <label class="block text-gray-700 font-semibold mb-2">{{ __('Games') }}</label>
            @foreach ($games as $game)
                <div class="flex items-center space-x-4 mb-2">
                    <input type="checkbox"
                           wire:click="toggleGames({{ $game->id }})"
                           @if(isset($gamesAppearance[$game->id])) checked @endif
                    >
                    <label>{{ $game->title }}</label>

                    @if(isset($gamesAppearance[$game->id]))
                        <input type="date"
                               wire:model.defer="gamesAppearance.{{ $game->id }}"
                               class="border rounded px-2 py-1 w-32"
                        >
                        @error("gamesAppearance.$game->id")
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Imagen --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Character Image')}}</label>
            <div x-data="{ dragging: false }"
                 class="border-2 border-dashed border-purple-500 p-6 text-center rounded-lg"
                 x-bind:class="{ 'bg-purple-100': dragging }"
                 x-on:dragover.prevent="dragging = true"
                 x-on:dragleave.prevent="dragging = false"
                 x-on:drop.prevent="dragging = false">
                <input type="file" wire:model="image" class="hidden" id="uploadImage">
                <p class="text-gray-600">{{__('Drag your image here or click to upload it')}}</p>
                <button type="button" onclick="document.getElementById('uploadImage').click()"
                        class="mt-2 bg-purple-600 text-white px-4 py-2 rounded-md">
                    {{__('Select Image')}}
                </button>
            </div>
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if ($imagePreview)
            <div class="mt-4">
                <p class="text-gray-700 font-semibold">{{__('Preview:')}}</p>
                <img src="{{ $imagePreview }}" alt="preview" class="w-auto max-w-full h-auto max-h-48 rounded-lg shadow-md mx-auto">
            </div>
        @endif
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="closeModalCreateEdit">{{ __('Cancel') }}</x-secondary-button>
        <x-button wire:click="{{ $isEditMode ? 'update' : 'store' }}">
            {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
        </x-button>
    </x-slot>
</x-dialog-modal>
