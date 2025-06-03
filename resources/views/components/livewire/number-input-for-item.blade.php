@props(['item', 'modelPrefix', 'model'])

@if(isset($model[$item->id]))
    <input type="number"
           wire:model.defer="{{ $modelPrefix }}.{{ $item->id }}"
           placeholder="Ventas"
           class="border rounded px-2 py-1 w-32"
           min="0"
           value="{{ $modelPrefix[$item->id] ?? 0 }}"
    >
    @error($modelPrefix . '.' . $item->id)
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
@endif
