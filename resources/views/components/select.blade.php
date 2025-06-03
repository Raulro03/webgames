@props(['items', 'model' => null, 'name' => null, 'selected' => null])

<select
    @if($model)
        wire:model="{{ $model }}"
    @elseif($name)
        name="{{ $name }}"
    @endif
    {{ $attributes->merge(['class' => 'block w-full mt-1']) }}
>
    <option value="">{{ __('Select a Option') }}</option>

    @foreach($items as $item)
        <option
            value="{{ $item->id }}"
            @if(!$model && $selected == $item->id) selected @endif
        >
            {{ $item->name ?? $item->category_type . ' , ' . $item->related_id }}
        </option>
    @endforeach
</select>
