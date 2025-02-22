@extends('layouts.webgames')

@section('content')

    <div class="mx-auto mt-8 max-w-6xl">

        <h1 class="text-center font-serif text-4xl md:text-5xl font-extrabold text-red-400">
            🗑️ {{__('Trashed Posts')}}
        </h1>

        <div class="mx-auto mt-8 grid max-w-6xl gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <article class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-slate-900 transition transform hover:scale-105">
                    <div class="p-4 flex flex-col justify-between h-full">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">{{ Str::limit($post->body, 100) }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="text-green-500 hover:underline">Restore</button>
                            </form>
                            <form action="{{ route('posts.forceDelete', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone!');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:underline">Delete Permanently</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if($posts->isEmpty())
            <p class="text-center text-gray-500 dark:text-gray-400 mt-8">No trashed posts found.</p>
        @endif
    </div>

@endsection
