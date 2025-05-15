<x-modal title="{{ __('Delete Character') }}" wire:model="DeleteModal" maxWidth="lg">
    <div class="p-6 space-y-6 text-center">
        <div class="text-2xl font-semibold text-red-600">
            {{ __('Are you sure?') }}
        </div>

        <p class="text-gray-700 dark:text-gray-300 text-base">
            {{ __('You are about to delete') }} <span class="font-bold">{{ $currentCharacter->name }}</span>.
            <br>
            {{ __('This action cannot be undone') }}
        </p>

        <div class="flex justify-center gap-4 pt-4">
            <button wire:click="delete"
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md transition">
                {{ __('Delete') }}
            </button>
            <button wire:click="$set('DeleteModal', false)"
                    class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow-md transition">
                {{ __('Cancel') }}
            </button>
        </div>
    </div>
</x-modal>
