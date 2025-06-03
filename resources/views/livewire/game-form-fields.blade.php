<form wire:submit.prevent="save" class="space-y-4 max-w-xl">

        <h1 class="text-2xl font-bold text-purple-600">
            {{ $game ? 'Editar Juego' : 'Crear Juego' }}
        </h1>

        <!-- Campo Título -->
        <x-input.input-text
            label="{{__('Title')}}"
            model="title"
            placeholder="Introduce el titulo del juego"
        />

        <!-- Campo Descripción -->
        <x-input.input-textarea
            label="{{ __('Description') }}"
            model="description"
            rows="3"
        />

        <!-- Campo Fecha de Lanzamiento -->
        <x-input.input-date
            label="{{ __('Release Date') }}"
            model="release_date"
        />

        <!-- Campo Rating Promedio -->
        <x-input.input-number
            label="{{ __('Average rating') }}"
            model="average_rating"
            step="0.01"
            min="0"
            max="10"
            placeholder="Ingresa un valor entre 0 y 10"
        />

        <!-- Campo Precio -->
        <x-input.input-number
            label="{{__('Price') . ' (€)'}}"
            model="price"
            step="1"
            min="0"
        />

        <!-- Selección de Desarrollador -->
        <div class="mb-4">
            <x-label :value="__('Developer')" class="text-gray-700 font-semibold" />
            <x-select
                :items="$developers"
                model="developer_id"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400"
            />
            @error('developer_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!--  Plataformas a elegir -->
            <div class="flex gap-6">
                <!-- Plataformas -->
                <div class="w-1/2 max-h-96 overflow-y-auto border p-2 rounded">
                    <x-label :value="__('Platforms')" class="text-gray-700 font-semibold mb-2" />
                    @foreach ($platforms as $platform)
                        <div class="flex items-center space-x-4 mb-2">
                            <x-livewire.checkbox-with-label
                                :item="$platform"
                                :selectedItems="$platformSales"
                                toggleMethod="togglePlatform"
                                labelField="name"
                            />

                            <x-livewire.number-input-for-item
                                :item="$platform"
                                modelPrefix="platformSales"
                                :model="$platformSales"
                            />
                        </div>
                    @endforeach
                </div>

                <!-- Personajes -->
                <div class="w-1/2 max-h-96 overflow-y-auto border p-2 rounded">
                    <x-label :value="__('Character')" class="text-gray-700 font-semibold mb-2" />
                    @foreach ($characters as $character)
                        <div class="flex items-center space-x-4 mb-2">
                            <x-livewire.checkbox-with-label
                                :item="$character"
                                :selectedItems="$characterAppearance"
                                toggleMethod="toggleCharacter"
                                labelField="name"
                            />

                            <x-livewire.date-input-for-item
                                :item="$character"
                                modelPrefix="characterAppearance"
                                :model="$characterAppearance"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
    <!-- Drag and Drop Imagen -->
        <div class="mb-4">
            <x-label :value="__('Game Image')" class="text-gray-700 font-semibold" />
            <x-livewire.drag-and-drop :imagePreview="$imagePreview" />
        </div>

    <x-primary-button type="submit" class="mt-4  " aria-label="Save">{{ __('Save') }}</x-primary-button>
</form>
