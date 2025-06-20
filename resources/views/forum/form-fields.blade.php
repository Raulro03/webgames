<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title"
                  name="title"
                  type="text"
                  value="{{ old('title', $post->title) }}"
                  class="block w-full mt-1"
    />
    <x-input-error-form :messages="$errors->get('title')" class="mt-2" />
</div>
<div>
    <x-input-label for="body" :value="__('Body')" />
    <x-textarea id="body"
                name="body"
                class="block w-full mt-1"
    >{{ old('body', $post->body) }}</x-textarea>
    <x-input-error-form :messages="$errors->get('body')" class="mt-2" />
</div>
<div>
    <x-input-label for="published_at" :value="__('Published on:')" />
    <x-text-input id="published_at"
                  name="published_at"
                  type="date"
                  value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}"
                  class="block w-full mt-1"
    />
    <x-input-error-form :messages="$errors->get('published_at')" class="mt-2" />
</div>
<div>
    <x-input-label for="category_id" :value="__('Category_Id')" />
    <x-select
        id="category_id"
        :items="$forumCategories"
        name="category_id"
        :selected="old('category_id', $post->category_id)"
        class="mb-4"
    />

    <x-input-error-form :messages="$errors->get('category_id')" class="mt-2" />
</div>
