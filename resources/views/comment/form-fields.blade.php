<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-textarea id="body"
                name="body"
                class="block w-full mt-1"
    >{{ old('body', $post->body) }}</x-textarea>
    <x-input-error-form :for="$errors->get('body')" class="mt-2" />
</div>
<div>
    <x-input-label for="published_at" :value="__('Published_At')" />
    <x-text-input id="published_at"
                  name="published_at"
                  type="date"
                  value="{{ old('published_at', $post->published_at) }}"
                  class="block w-full mt-1"
    />
    <x-input-error-form :for="$errors->get('published_at')" class="mt-2" />
</div>
