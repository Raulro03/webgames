@props([
    'label' => '',
    'model' => '',
])

<div class="mb-4">
    @if($label)
        <x-label :value="$label" />
    @endif

    <input
        wire:model="{{ $model }}"
        type="date"
        class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-purple-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"
    />

    @error($model)
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
