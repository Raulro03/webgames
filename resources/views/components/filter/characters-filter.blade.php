<div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nombre</label>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar personaje"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Edad mínima</label>
            <input type="number" wire:model.live.debounce.300ms="min_age" min="0"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Edad máxima</label>
            <input type="number" wire:model.live.debounce.300ms="max_age" min="0"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Constitución mínima</label>
            <input type="number" wire:model.live.debounce.300ms="min_constitution" min="0"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Fuerza mínima</label>
            <input type="number" wire:model.live.debounce.300ms="min_strength" min="0"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Agilidad mínima</label>
            <input type="number" wire:model.live.debounce.300ms="min_agility" min="0"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Inteligencia mínima</label>
            <input type="number" wire:model.live.debounce.300ms="min_intelligence" min="0"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Carisma mínima</label>
            <input type="number" wire:model.live.debounce.300ms="min_charisma" min="0"
                   class="w-full px-4 py-2 border rounded focus:ring focus:ring-indigo-200 dark:bg-gray-800 dark:text-white">
        </div>
        <x-filter.button-clean-filter/>
    </div>
</div>
