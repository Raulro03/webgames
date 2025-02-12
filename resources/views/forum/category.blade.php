@extends('layouts.webgames')

@section('content')

    <div class="container mx-auto py-12 px-6">
        <h1 class="text-4xl font-extrabold text-purple-300 text-center mb-8">Posts de la Categoría</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <h2 class="text-xl font-semibold text-purple-300 mb-3">{{ $post->title }}</h2>
                    <p class="text-sm text-purple-200">{{ Str::limit($post->body, 100) }}</p>
                    <a href="{{ route('forum.show', $post->id) }}" class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                        Leer más →
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
