@extends('layouts.webgames')

@section('content')
    @if (session('status'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             class="container mx-auto p-4">
            <div class="bg-green-600 text-white p-4 rounded-lg shadow-md text-center transition-opacity duration-500 ease-in-out animate-fade-in">
                <p>{{ session('status') }}</p>
            </div>
        </div>
    @endif
    <div class="container mx-auto py-12 px-6">

        @if(Auth::user()->hasRole('admin') || Auth::user()->id == $post->user_id && Auth::user()->hasRole('author'))
            <div
                class="flex items-center justify-center space-x-10 mb-3"
            >
                <a
                    class="flex items-center gap-2 px-5 py-3 rounded-lg bg-gradient-to-r from-blue-500 to-blue-700
                        text-white font-semibold shadow-md transition duration-300 hover:scale-105 hover:from-blue-600
                        hover:to-blue-800 focus:ring-4 focus:ring-blue-300"
                    href="{{ route('post.edit', $post) }}"
                >
                    <svg
                        class="h-6 w-6"
                        data-slot="icon"
                        fill="none"
                        stroke-width="1.5"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"
                        ></path>
                    </svg>
                </a>
                <form action="{{ route('post.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="flex items-center gap-2 px-5 py-3 rounded-lg bg-gradient-to-r from-red-500 to-red-700
                            text-white font-semibold shadow-md transition duration-300 hover:scale-105 hover:from-red-600
                            hover:to-red-800 focus:ring-4 focus:ring-red-300"
                    >
                        <svg
                            class="h-6 w-6"
                            data-slot="icon"
                            fill="none"
                            stroke-width="1.5"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                            ></path>
                        </svg>
                    </button>
                </form>
            </div>
        @endif
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-purple-600 text-white text-center py-6">
                <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
                <p class="text-purple-200 text-sm">Publicado por {{ $post->user->name }} - {{ $post->created_at->diffForHumans() }}</p>
            </div>
            <div class="p-6 text-gray-800 leading-relaxed">
                <p>{{ $post->body }}</p>
            </div>
            <div class="p-4 text-gray-800 leading-relaxed">
                <p><strong>Categoría:</strong> {{ $post->forum_category->category_type." , ".$post->forum_category->related_id }}</p>
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
