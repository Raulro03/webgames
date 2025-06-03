@props([
    'label' => null,
    'model' => null,
    'step' => '1',
    'min' => null,
    'max' => null,
    'placeholder' => '',
])

<div class="mb-4">
    @if($label)
        <x-label :value="$label"/>
    @endif

    <input
        type="number"
        wire:model="{{ $model }}"
        step="{{ $step }}"
        @if(!is_null($min)) min="{{ $min }}" @endif
        @if(!is_null($max)) max="{{ $max }}" @endif
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-purple-300 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white'
        ]) }}
    />

    @error($model) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>
