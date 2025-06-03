<form wire:submit.prevent="save" class="space-y-4 max-w-xl">

        <h1 class="text-2xl font-bold text-purple-600">
            {{ $game ? 'Editar Juego' : 'Crear Juego' }}
        </h1>

        <!-- Campo Título -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Title')}}</label>
            <input type="text" wire:model="title" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Descripción -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Description')}}</label>
            <textarea wire:model="description" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Fecha de Lanzamiento -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Release Date')}}</label>
            <input type="date" wire:model="release_date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('release_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Rating Promedio -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Average rating')}}</label>
            <input type="number" wire:model="average_rating" step="0.01" min="0" max="10" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('average_rating') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Precio -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Price')}} (€)</label>
            <input type="number" wire:model="price" step="1" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Selección de Desarrollador -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Developer')}}</label>
            <select wire:model="developer_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
                <option value="">Selecciona un desarrollador</option>
                @foreach($developers as $developer)
                    <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                @endforeach
            </select>
            @error('developer_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!--  Plataformas a elegir -->
            <div class="flex gap-6">
                <!-- Plataformas -->
                <div class="w-1/2 max-h-96 overflow-y-auto border p-2 rounded">
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Platforms') }}</label>
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
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Character') }}</label>
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
            <label class="block text-gray-700 font-semibold">{{ __('Game Image') }}</label>
            <x-livewire.drag-and-drop :imagePreview="$imagePreview" />
        </div>

    <x-primary-button type="submit" class="mt-4  " aria-label="Save">{{ __('Save') }}</x-primary-button>
</form>
