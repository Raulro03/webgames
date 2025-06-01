@if(session('status_pdf'))
    <p class="text-green-600 dark:text-green-400">{{ session('status_pdf') }}</p>
@endif
<div class="m-4">
    <a href="{{ route('dashboard.pdf') }}" class=" inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700">
        {{__('Generate PDF History User')}}
    </a>
    @if($pdfReady)
    <a href="{{ route('user.download.pdf') }}"
       class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
        {{__('Download PDF History User')}}
    </a>
    @endif
</div>

