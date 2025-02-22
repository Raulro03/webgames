@extends('layouts.webgames')

@section('content')

    <div class="container mx-auto py-12 px-6">
        <h1 class="text-4xl font-extrabold text-purple-600 text-center mb-8">{{__('Category Posts')}}</h1>
        <a href="{{ route('post.create') }}" class=" mb-3 bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700">
            {{__('Create Post')}}
        </a>
        @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
            @foreach($posts as $post)
                <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <h2 class="text-xl font-semibold text-purple-300 mb-3">{{ $post->title }}</h2>
                    <p class="text-sm text-purple-200">{{ Str::limit($post->body, 100) }}</p>
                    <div class="flex items-center mt-4">
                        <img class="h-10 w-10 rounded-full border-2 border-purple-500 object-cover shadow-lg"
                             src="https://ui-avatars.com/api?name={{ urlencode($post->user->name) }}"
                             alt="{{ $post->user->name }}"/>

                        <div class="ml-3">
                            <p class="text-xs text-purple-400">
                                📅 {{ __('Published on:') }} <span class="font-medium">{{ $post->published_at->format('d/m/Y') }}</span>
                            </p>
                            <p class="text-sm font-medium text-purple-300">
                                {{ __('By') }} {{ $post->user->name }}
                            </p>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('post.show', $post)}}" class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                        {{ __('Read more') }} →
                    </a>
                </div>
            @endforeach
        </div>
        @else
            <div class="container mx-auto py-12 px-6 text-center">
                <p class=" text-purple-600 text-2xl mt-12">{{ __('No posts in this category') }}</p>
            </div>
        @endif
    </div>
    <div class="d-flex m-3 px-6 justify-content-center">
        {{ $posts->links() }}
    </div>


@endsection
