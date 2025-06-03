@props(['item', 'selectedItems', 'toggleMethod', 'labelField' => 'name'])
 <input type="checkbox"
           wire:click="{{ $toggleMethod }}({{ $item->id }})"
           @if(isset($selectedItems[$item->id])) checked @endif
           class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring focus:ring-purple-200">
<label class="ml-2 text-sm text-gray-700">{{ $item->{$labelField} }}</label>

