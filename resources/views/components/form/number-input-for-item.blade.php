@props(['item', 'modelPrefix'])

@if(isset($modelPrefix[$item->id]))
    <input type="number"
           wire:model="{{ $modelPrefix }}.{{ $item->id }}"
           step="1"
           min="0"
           class="w-24 px-2 py-1 border rounded-lg focus:ring-2 focus:ring-purple-400">
    @error($modelPrefix . '.' . $item->id)
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
@endif
