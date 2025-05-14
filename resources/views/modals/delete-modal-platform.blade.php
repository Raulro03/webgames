<x-modal title="Eliminar Plataforma" wire:model="DeleteModal">
    <div class="text-center space-y-4">
        <p class="text-lg font-semibold text-red-600">
            ¿{{__("Delete Platform")}}?
        </p>
        <p class="text-gray-700 dark:text-gray-300">
            ¿{{__("Are you sure you want to delete")}} <strong>{{ $currentPlatform->name }}</strong>? {{__("This action cannot be undone")}}.
        </p>
        <div class="flex justify-center space-x-3 pt-4">
            <button wire:click="delete"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                {{__("Delete")}}
            </button>
            <button wire:click="$set('DeleteModal', false)"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                {{__("Close")}}
            </button>
        </div>
    </div>
</x-modal>
