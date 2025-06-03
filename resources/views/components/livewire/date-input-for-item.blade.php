@props(['item', 'modelPrefix', 'model'])

@if(isset($model[$item->id]))
    <input type="date"
           wire:model.defer="{{ $modelPrefix }}.{{ $item->id }}"
           class="border rounded px-2 py-1 w-32">
    @error($modelPrefix . '.' . $item->id)
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
@endif


