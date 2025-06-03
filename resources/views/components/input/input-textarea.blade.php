@props([
    'label' => '',
    'model' => '',
    'rows' => 4,
    'placeholder' => '',
])

<div class="mb-4">
    @if($label)
        <x-label :value="$label" />
    @endif

    <textarea
        wire:model="{{ $model }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-purple-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"
    ></textarea>

    @error($model)
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
