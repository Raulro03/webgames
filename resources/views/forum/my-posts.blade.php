@extends('layouts.webgames')

@section('content')

    <div class="mx-auto mt-8 max-w-6xl">

        <h1 class="text-center font-serif text-4xl md:text-5xl font-extrabold text-purple-400">
            📌 {{__('My Posts')}}
        </h1>

        <div class="mx-auto mt-8 grid max-w-6xl gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <article class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-slate-900 transition transform hover:scale-105 duration-300">
                    <div class="flex-1 space-y-4 p-6">

                        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">
                            <a href="{{ route('post.show', $post) }}" class="hover:text-purple-500 transition">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                            {{ $post->body }}
                        </p>

                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            📅 {{__('Published on:')}}: <span class="font-medium">{{ $post->published_at->format('d/m/Y') }}</span>
                        </p>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6 flex justify-center">
            {{ $posts->links() }}
        </div>

        <a href="{{ route('post.create') }}"
           class="fixed top-24 left-8 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition-all duration-300">
            ➕ {{__('New Post')}}
        </a>
    </div>
@endsection
