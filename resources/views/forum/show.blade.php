@extends('layouts.webgames')

@section('content')
    <div class="container mx-auto py-12 px-6">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-purple-600 text-white text-center py-6">
                <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
                <p class="text-purple-200 text-sm">Publicado por {{ $post->user->name }} - {{ $post->created_at->diffForHumans() }}</p>
            </div>
            <div class="p-6 text-gray-800 leading-relaxed">
                <p>{{ $post->body }}</p>
            </div>
        </div>

        <!-- Sección de Comentarios -->
        <div class="max-w-3xl mx-auto mt-10">
            <h2 class="text-2xl font-bold text-purple-600 mb-4">Comentarios</h2>
            <div class="space-y-4">
                @foreach ($post->comments as $comment)

                    <div class="bg-purple-100 p-4 rounded-lg shadow-md">
                        <p class="text-sm text-purple-700">{{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}</p>
                        <p class="mt-2 text-gray-800">{{ $comment->body }}</p>

                        <!-- Respuestas -->
                        @if ($comment->replies->count())

                            <div class="mt-4 ml-6 border-l-2 border-purple-400 pl-4 space-y-2">
                                @foreach ($comment->replies as $reply)
                                    <div class="bg-purple-200 p-3 rounded-md">
                                        <p class="text-sm text-purple-800">{{ $reply->user->name }} - {{ $reply->created_at->diffForHumans() }}</p>
                                        <p class="text-gray-900">{{ $reply->body }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
