<div class="bg-purple-100 p-4 rounded-lg shadow-md">
    <div class="flex justify-between items-center">
        <p class="text-sm text-purple-700">{{ $comment->user->name }} - {{ $comment->published_at->diffForHumans() }}</p>
        <div class="flex space-x-2">
            <a href="{{ route('replies.create', ['post' => $post->id, $comment]) }}" class="text-purple-600 hover:text-purple-900">Comentar</a>

            @can('update', $comment)
            <a href="{{ route('comment.edit', [$post, $comment]) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
            @endcan

            @can('delete', $comment)
            <form action="{{ route('comment.destroy', [$post, $comment]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
            </form>
            @endcan

        </div>
    </div>
    <p class="mt-2 text-gray-800">{{ $comment->body }}</p>

    @if ($comment->replies->count())
        <div class="mt-4 ml-6 border-l-2 border-purple-400 pl-4 space-y-2">
            @foreach ($comment->replies as $reply)
                @include('components.comment-item', ['comment' => $reply, 'post' => $post])
            @endforeach
        </div>
    @endif
</div>
