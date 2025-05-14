<div class="max-w-7xl mx-auto mt-10 p-4">
    {{-- Botón Crear --}}
    <div class="flex justify-end mb-6">
        <button wire:click="create" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
            + {{__("New Platform")}}
        </button>
    </div>

    {{-- Grid de tarjetas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($platforms as $platform)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <img src="{{ $platform->image_url }}" alt="Imagen Platform" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $platform->name }}</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        {{ Str::limit($platform->description, 50) }}
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ number_format($platform->price / 100, 2, ',', '.') }}€
                        </span>
                        <div class="space-x-2">
                            <button wire:click="show({{ $platform->id }})"
                                    class="text-blue-500 hover:underline">{{__("See")}}</button>
                            <button wire:click="edit({{ $platform->id }})"
                                    class="text-yellow-500 hover:underline">{{__('Edit')}}</button>
                            <button wire:click="confirmDelete({{ $platform->id }})"
                                    class="text-red-500 hover:underline">{{__("Delete")}}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 flex justify-center">
        {{ $platforms->links() }}
    </div>

    {{-- Modal Crear / Editar --}}
    @if($FormModal)
        @include('modals.form-modal-platform')
    @endif

    {{-- Modal Mostrar --}}
    @if ($ShowModal && $currentPlatform)
        @include('modals.show-modal-platform')
    @endif

    {{-- Modal Confirmar Eliminación --}}
    @if ($DeleteModal && $currentPlatform)
        @include('modals.delete-modal-platform')
    @endif
</div>
