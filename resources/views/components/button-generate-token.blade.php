<div class="p-6">
    <form action="{{ route('user.generate.tokens') }}" method="POST" class="mb-6">
        @csrf
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl shadow">
            {{__('Generate Token')}}
        </button>
    </form>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow" role="alert">
            <span class="block whitespace-pre-line">{{ session('success') }}</span>
        </div>
    @endif
</div>
