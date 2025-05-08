<form wire:submit.prevent="save" class="space-y-4 max-w-xl">

        <h1 class="text-2xl font-bold text-purple-600">
            {{ $game ? 'Editar Juego' : 'Crear Juego' }}
        </h1>

        <!-- Campo Título -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Título</label>
            <input type="text" wire:model="title" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Descripción -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Descripción</label>
            <textarea wire:model="description" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400"></textarea>
            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Fecha de Lanzamiento -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Fecha de Lanzamiento</label>
            <input type="date" wire:model="release_date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('release_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Rating Promedio -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Rating Promedio</label>
            <input type="number" wire:model="average_rating" step="0.01" min="0" max="10" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('average_rating') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Campo Precio -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Precio (€)</label>
            <input type="number" wire:model="price" step="1" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
            @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Selección de Desarrollador -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Desarrollador</label>
            <select wire:model="developer_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
                <option value="">Selecciona un desarrollador</option>
                @foreach($developers as $developer)
                    <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                @endforeach
            </select>
            @error('developer_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Plataformas</label>
            @foreach ($platforms as $platform)
                <div class="flex items-center space-x-4 mb-2">
                    <!-- Checkbox -->
                    <input type="checkbox"
                           wire:click="togglePlatform({{ $platform->id }})"
                           @if(isset($selectedPlatforms[$platform->id])) checked @endif
                    >
                    <label>{{ $platform->name }}</label>

                    <!-- Input de ventas -->
                    @if(isset($selectedPlatforms[$platform->id]))
                        <input type="number"
                               wire:model.defer="platformSales.{{ $platform->id }}"
                               placeholder="Ventas"
                               class="border rounded px-2 py-1 w-32"
                               min="0"
                        >
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Drag and Drop Imagen -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Imagen del Juego</label>
            <div x-data="{ dragging: false }"
                 class="border-2 border-dashed border-purple-500 p-6 text-center rounded-lg"
                 x-bind:class="{ 'bg-purple-100': dragging }"
                 x-on:dragover.prevent="dragging = true"
                 x-on:dragleave.prevent="dragging = false"
                 x-on:drop.prevent="dragging = false">
                <input type="file" wire:model="image" class="hidden" id="uploadImage">
                <p class="text-gray-600">Arrastra aquí tu imagen o haz click para subirla</p>
                <button type="button" onclick="document.getElementById('uploadImage').click()"
                        class="mt-2 bg-purple-600 text-white px-4 py-2 rounded-md">
                    Seleccionar Imagen
                </button>
            </div>
            @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>


        @if ($imagePreview)
            <div class="mt-4">
                <p class="text-gray-700 font-semibold">Vista previa:</p>
                <img src="{{ $imagePreview }}" alt="preview" class="w-40 rounded-lg shadow-md">
            </div>
        @endif

    <x-primary-button type="submit" class="mt-4  " aria-label="Save">{{ __('Save') }}</x-primary-button>
</form>
