<x-dialog-modal wire:model="FormModal" maxWidth="2xl">
    <x-slot name="title">
        {{ $isEditMode ? __("Edit Platform") : __('Create Platform') }}
    </x-slot>

    <x-slot name="content">
        {{-- Nombre --}}
        <div class="mb-4">
            <x-label :value="__('Name')" />
            <input wire:model="name" type="text"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-4">
            <x-label :value="__('Description')" />
            <textarea wire:model="description"
                      class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                      rows="3"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Fecha de lanzamiento --}}
        <div class="mb-4">
            <x-label :value="__('Release Date')" />
            <input wire:model="release_date" type="date"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('release_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Precio --}}
        <div class="mb-4">
            <x-label :value="__('Price') . ' (€)'" />
            <input wire:model="price" type="number" step="1" min="0"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Rating medio --}}
        <div class="mb-4">
            <x-label :value="__('Average rating')" />
            <input wire:model="average_rating" type="number" step="0.01" max="9.99"
                   class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            @error('average_rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Juegos --}}
        <div class="mb-4 w-full max-h-64 overflow-y-auto border p-2 rounded">
            <x-label :value="__('Games')" class="font-semibold mb-2 text-gray-700" />
            @foreach ($games as $game)
                <div class="flex items-center space-x-4 mb-2">
                    <x-livewire.checkbox-with-label
                        :item="$game"
                        :selectedItems="$gamesSales"
                        toggleMethod="toggleGames"
                        labelField="title"
                    />

                    <x-livewire.number-input-for-item
                        :item="$game"
                        modelPrefix="gamesSales"
                        :model="$gamesSales"
                    />
                </div>
            @endforeach
        </div>

        {{-- Imagen --}}
        <div class="mb-4">
            <x-label :value="__('Platform Image')" class="font-semibold text-gray-700" />
            <x-livewire.drag-and-drop :imagePreview="$imagePreview" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="closeModalCreateEdit">{{ __('Cancel') }}</x-secondary-button>
        <x-button wire:click="{{ $isEditMode ? 'update' : 'store' }}">
            {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
        </x-button>
    </x-slot>
</x-dialog-modal>
