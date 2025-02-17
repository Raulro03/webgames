@extends('layouts.webgames')

@section('content')

    <div class="container mx-auto py-12 px-6">
        <h1 class="text-4xl font-extrabold text-purple-600 text-center mb-8">Posts de la Categoría</h1>
        <a href="{{ route('post.create') }}" class=" mb-3 bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700">
            Create Post
        </a>
        @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
            @foreach($posts as $post)
                <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <h2 class="text-xl font-semibold text-purple-300 mb-3">{{ $post->title }}</h2>
                    <p class="text-sm text-purple-200">{{ Str::limit($post->body, 100) }}</p>
                    <p class="text-xs text-purple-400 mt-2">📅 Publicado el: <span class="font-medium">{{ $post->published_at->format('d/m/Y') }}</span></p>
                    <a href="{{ route('post.show', $post)}}" class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                        Leer más →
                    </a>
                </div>
            @endforeach
        </div>
        @else
            <div class="container mx-auto py-12 px-6 text-center">
                <p class=" text-purple-600 text-2xl mt-12">No hay posts en esta categoría</p>
            </div>
        @endif
    </div>
    <div class="d-flex m-3 px-6 justify-content-center">
        {{ $posts->links() }}
    </div>


@endsection
