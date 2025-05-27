<div class="p-4 rounded-lg">
    <h3 class="text-lg font-bold text-purple-600 mb-2">{{__('Request new banned word')}}</h3>
    @if(session('status'))
        <p class="text-green-600 dark:text-green-400">{{ session('status') }}</p>
    @endif
    <form action="{{ route('forbidden-words.request') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-2">
        @csrf
        <input type="text" name="word" placeholder="Palabra ofensiva..." required
               class="rounded-lg border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 w-full sm:w-auto">
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
            {{__('Send')}}
        </button>
    </form>
</div>
