<x-dialog-modal wire:model="FormModal" maxWidth="2xl">
    <x-slot name="title">
        {{ $isEditMode ? __("Edit Platform") : __('Create Platform') }}
    </x-slot>

    <x-slot name="content">
        {{-- Nombre --}}
        <x-input.input-text
            label="{{__('Name')}}"
            model="name"
            placeholder="Introduce el nombre del juego"
        />

        {{-- Descripción --}}
        <x-input.input-textarea
            label="{{ __('Description') }}"
            model="description"
            rows="3"
        />

        {{-- Fecha de lanzamiento --}}
        <x-input.input-date
            label="{{ __('Release Date') }}"
            model="release_date"
        />

        {{-- Precio --}}
            <x-input.input-number
                label="{{__('Price') . ' (€)'}}"
                model="price"
                step="1"
                min="0"
            />

        {{-- Rating medio --}}
        <x-input.input-number
            label="{{ __('Average rating') }}"
            model="average_rating"
            step="0.01"
            min="0"
            max="10"
            placeholder="Ingresa un valor entre 0 y 10"
        />

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
