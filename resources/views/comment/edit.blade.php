@extends('layouts.webgames')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Comment') }} </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('comment.update', [$post, $comment]) }}"
                          class="space-y-4 max-w-xl">
                        @csrf
                        @method('PATCH')
                        @include('comment.form-fields')
                        <div class="flex justify-end mt-4">
                            <a href="{{ route('post.show', $post) }}"
                               class="bg-gray-400 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-500">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="ml-3 bg-purple-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-purple-700">
                                Editar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
