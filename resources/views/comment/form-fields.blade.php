<div>
    <h3 class="text-lg font-bold">{{__('You are responding to the post')}} {{ $post->title }}</h3>
</div>
@if (optional($parent_comment)->exists && $parent_comment)
    <div class="mt-4">
        <h4 class="text-md font-semibold">{{__('Responding to')}}:</h4>
        <p class="text-sm text-gray-600">{{ $parent_comment->user->name }} - {{ $parent_comment->created_at->diffForHumans() }}</p>
        <p class="mt-2 text-gray-800">{{ $parent_comment->body }}</p>
    </div>
    <input type="hidden" name="parent_id" value="{{ $parent_comment->id}}">
@else
    <div class="mt-4">
        <h4 class="text-md font-semibold">{{__('Top Comment')}}</h4>
    </div>
@endif

@error('parent_id')
    <div class="text-red-500 text-sm mt-1">
        {{ $message }}
    </div>
@enderror


<input type="hidden" name="post_id" value="{{ $post->id }}">


<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-textarea id="body"
                name="body"
                class="block w-full mt-1"
    >{{ old('body', $comment->body) }}</x-textarea>
    <x-input-error-form :messages="$errors->get('body')" class="mt-2" />
</div>
