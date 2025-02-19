@extends('layouts.webgames')

@section('content')
    <div class="mx-auto mt-4 max-w-6xl">
        <h1 class="my-4 text-center font-serif text-4xl font-extrabold text-sky-600 md:text-5xl">
            Mis Comentarios
        </h1>
        <div class="mx-auto mt-8 grid max-w-6xl gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($comments as $comment)
                <article class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900 p-5">
                    <div class="flex-1 space-y-3">
                        <h2 class="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200">
                            <a class="hover:underline" href="{{ route('post.show', $comment->post_id) }}">
                                {{ $comment->post->title }}
                            </a>
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400">
                            {{ Str::limit($comment->body, 100) }}
                        </p>
                        <p class="text-sm text-gray-600">📅 Publicado el: <span class="font-medium">{{ $comment->created_at->format('d/m/Y') }}</span></p>
                    </div>
                    <div class="flex justify-between mt-4">
                        <a href="{{ route('comment.edit',  [$comment->post_id, $comment]) }}" class="px-3 py-2 text-blue-600 hover:text-blue-900">Editar</a>
                        <form action="{{ route('comment.destroy', [$comment->post_id, $comment]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 text-red-600 hover:text-red-900">Eliminar</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
    <div class="d-flex mt-3 px-6 justify-content-center">
        {{ $comments->links() }}
    </div>
@endsection
