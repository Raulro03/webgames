<x-modal title="Detalles de la Plataforma" wire:model="ShowModal" maxWidth="2xl">
    <div class="relative bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-purple-500">
        <!-- Barra superior animada -->
        <div class="absolute top-0 left-0 w-full h-2 bg-purple-500 rounded-t-2xl animate-pulse"></div>

        <!-- Título -->
        <h1 class="text-4xl font-bold text-center text-purple-600 dark:text-purple-400 mb-6">
            {{ $currentCharacter->name }}
        </h1>

        <div class="flex flex-col md:flex-row items-center">
            <!-- Imagen -->
            <img src="{{ asset($currentCharacter->image_url) }}"
                 alt="Imagen de {{ $currentCharacter->name }}"
                 class="w-64 h-64 object-cover rounded-lg shadow-md border border-gray-300 mb-4 md:mb-0">

            <!-- Información -->
            <div class="md:ml-6 text-gray-700 dark:text-gray-300 space-y-3">
                <p><strong>{{__("Description")}}:</strong> {{ $currentCharacter->description }}</p>
                <p><strong>{{__("Age")}}:</strong> {{ $currentCharacter->age }}</p>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-6 text-center space-x-4">
            <button wire:click="$set('ShowModal', false)"
                    class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                {{__("Close")}}
            </button>
        </div>
    </div>
</x-modal>
