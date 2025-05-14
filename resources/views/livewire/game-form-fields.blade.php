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
                            <input type="checkbox"
                                   wire:click="togglePlatform({{ $platform->id }})"
                                   @if(isset($platformSales[$platform->id])) checked @endif
                            >
                            <label>{{ $platform->name }}</label>

                            @if(isset($platformSales[$platform->id]))
                                <input type="number"
                                       wire:model.defer="platformSales.{{ $platform->id }}"
                                       placeholder="Ventas"
                                       class="border rounded px-2 py-1 w-32"
                                       min="0"
                                       value="{{$platformSales[$platform->id] ?? 0}}"
                                >
                                @error("platformSales.$platform->id")
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Personajes -->
                <div class="w-1/2 max-h-96 overflow-y-auto border p-2 rounded">
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Character') }}</label>
                    @foreach ($characters as $character)
                        <div class="flex items-center space-x-4 mb-2">
                            <input type="checkbox"
                                   wire:click="toggleCharacter({{ $character->id }})"
                                   @if(isset($characterAppearance[$character->id])) checked @endif
                            >
                            <label>{{ $character->name }}</label>

                            @if(isset($characterAppearance[$character->id]))
                                <input type="date"
                                       wire:model.defer="characterAppearance.{{ $character->id }}"
                                       class="border rounded px-2 py-1 w-48"
                                >
                                @error("characterAppearance.$character->id")
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        <!-- Drag and Drop Imagen -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">{{__('Game Image')}}</label>
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
            @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>


        @if ($imagePreview)
            <div class="mt-4">
                <p class="text-gray-700 font-semibold">{{__('Preview:')}}</p>
                <img src="{{ $imagePreview }}" alt="preview" class="w-40 rounded-lg shadow-md">
            </div>
        @endif

    <x-primary-button type="submit" class="mt-4  " aria-label="Save">{{ __('Save') }}</x-primary-button>
</form>
