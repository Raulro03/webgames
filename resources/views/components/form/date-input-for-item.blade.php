@props(['item', 'modelPrefix' => 'characterAppearance'])

@if(isset(${$modelPrefix}[$item->id]))
    <input type="date"
           wire:model.defer="{{ $modelPrefix }}.{{ $item->id }}"
           class="border rounded px-2 py-1 w-48">
    @error($modelPrefix . '.' . $item->id)
    <p class="text-red-500 text-sm text-left mt-1">{{ $message }}</p>
    @enderror
@endif


