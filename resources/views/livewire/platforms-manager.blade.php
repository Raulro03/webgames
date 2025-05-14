<div class="max-w-7xl mx-auto mt-10 p-4">
    {{-- Botón Crear --}}
    <div class="flex justify-end mb-6">
        <button wire:click="create" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
            + Nueva Plataforma
        </button>
    </div>

    {{-- Grid de tarjetas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($platforms as $platform)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <img src="{{ $platform->image_url }}" alt="Imagen Platform" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $platform->name }}</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        {{ Str::limit($platform->description, 50) }}
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ number_format($platform->price / 100, 2, ',', '.') }}€
                        </span>
                        <div class="space-x-2">
                            <button wire:click="show({{ $platform->id }})"
                                    class="text-blue-500 hover:underline">Ver</button>
                            <button wire:click="edit({{ $platform->id }})"
                                    class="text-yellow-500 hover:underline">Editar</button>
                            <button wire:click="confirmDelete({{ $platform->id }})"
                                    class="text-red-500 hover:underline">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 flex justify-center">
        {{ $platforms->links() }}
    </div>

    {{-- Modal Crear / Editar --}}
    @if($FormModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-800 w-full max-w-xl mx-auto rounded-lg shadow-lg p-6 overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                        {{ $isEditMode ? 'Editar Plataforma' : 'Crear Plataforma' }}
                    </h2>
                    <button wire:click="closeModalCreateEdit" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl">
                        &times;
                    </button>
                </div>

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="space-y-4">
                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input wire:model="name" type="text"
                               class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                        <textarea wire:model="description"
                                  class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                  rows="3"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Fecha de lanzamiento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de lanzamiento</label>
                        <input wire:model="release_date" type="date"
                               class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        @error('release_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio (€)</label>
                        <input wire:model="price" type="number" step="1" min="0"
                               class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Rating medio --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating medio</label>
                        <input wire:model="average_rating" type="number" step="0.01" max="9.99"
                               class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        @error('average_rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-6">
                        <!-- Juegos -->
                        <div class="w-1/2 max-h-96 overflow-y-auto border p-2 rounded">
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
                                               value="{{$gamesSales[$game->id] ?? 0}}"
                                        >
                                        @error("gamesSales.$game->id")
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Imagen --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">{{__('Platform Image')}}</label>
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

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModalCreateEdit"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md shadow-sm">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm">
                            {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Mostrar --}}
    @if ($ShowModal && $currentPlatform)
        <x-modal title="Detalles de la Plataforma" wire:model="ShowModal" maxWidth="2xl">
            <div class="relative bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-purple-500">
                <!-- Barra superior animada -->
                <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

                <!-- Título -->
                <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400 mb-6">
                    {{ $currentPlatform->name }}
                </h1>

                <div class="flex flex-col md:flex-row items-center">
                    <!-- Imagen -->
                    <img src="{{ asset('storage/' . $currentPlatform->image_url) }}"
                         alt="Imagen de {{ $currentPlatform->name }}"
                         class="w-64 h-64 object-cover rounded-lg shadow-md border border-gray-300 mb-4 md:mb-0">

                    <!-- Información -->
                    <div class="md:ml-6 text-gray-700 dark:text-gray-300 space-y-3">
                        <p><strong>Descripción:</strong> {{ $currentPlatform->description }}</p>
                        <p><strong>Precio:</strong> {{ number_format($currentPlatform->price / 100, 2, ',', '.') }}€</p>
                        <p><strong>Calificación Promedio:</strong> {{ $currentPlatform->average_rating }}</p>
                        <p><strong>Fecha de Lanzamiento:</strong> {{ \Carbon\Carbon::parse($currentPlatform->release_date)->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-6 text-center space-x-4">
                    <button wire:click="$set('ShowModal', false)"
                            class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                        Cerrar
                    </button>

                    <x-download-pdf-button route="platform.pdf" :id="$currentPlatform->id" />
                </div>
            </div>
        </x-modal>
    @endif

    {{-- Modal Confirmar Eliminación --}}
    @if ($DeleteModal && $currentPlatform)
        <x-modal title="Eliminar Plataforma" wire:model="DeleteModal">
            <div class="text-center space-y-4">
                <p class="text-lg font-semibold text-red-600">
                    ¿Eliminar plataforma?
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    ¿Estás seguro de que deseas eliminar <strong>{{ $currentPlatform->name }}</strong>? Esta acción no se puede deshacer.
                </p>
                <div class="flex justify-center space-x-3 pt-4">
                    <button wire:click="delete"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        Eliminar
                    </button>
                    <button wire:click="$set('DeleteModal', false)"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                        Cancelar
                    </button>
                </div>
            </div>
        </x-modal>
    @endif
</div>
