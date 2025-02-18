<div>
    <h3 class="text-lg font-bold">Estas respondiendo al post : {{ $post->title }}</h3>
</div>
@if (optional($parent_comment)->exists && $parent_comment)
    <div class="mt-4">
        <h4 class="text-md font-semibold">Respondiendo a:</h4>
        <p class="text-sm text-gray-600">{{ $parent_comment->user->name }} - {{ $parent_comment->created_at->diffForHumans() }}</p>
        <p class="mt-2 text-gray-800">{{ $parent_comment->body }}</p>
    </div>

@else
    <div class="mt-4">
        <h4 class="text-md font-semibold">Comentario principal</h4>
    </div>
@endif

<input type="hidden" name="parent_id" value="{{ $parent_comment->id}}">

<input type="hidden" name="post_id" value="{{ $post->id }}">


<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-textarea id="body"
                name="body"
                class="block w-full mt-1"
    >{{ old('body', $comment->body) }}</x-textarea>
    <x-input-error-form :messages="$errors->get('body')" class="mt-2" />
</div>
