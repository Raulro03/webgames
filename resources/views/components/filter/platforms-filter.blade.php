<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('Search by name')}}</label>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Ej: PlayStation" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('Min price')}}</label>
        <input type="number" wire:model.live.debounce.300ms="min_price" placeholder="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('Max price')}}</label>
        <input type="number" wire:model.live.debounce.300ms="max_price" placeholder="1000" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('Min rating')}}</label>
        <input type="number" step="0.1" wire:model.live.debounce.300ms="min_rating" placeholder="1.0" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('Max rating')}}</label>
        <input type="number" step="0.1" wire:model.live.debounce.300ms="max_rating" placeholder="10.0" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('Release date from')}}</label>
        <input type="date" wire:model.live.debounce.300ms="release_from" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('Release date to')}}</label>
        <input type="date" wire:model.live.debounce.300ms="release_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
    </div>

    <button wire:click="resetFilters" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition">{{__('Clean filter')}}</button>
</div>
