<div class="max-w-7xl mx-auto mt-10 p-4">
    @can('create', \App\Models\Character::class)
    <div class="flex justify-end mb-6">
        <button wire:click="create" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
            + {{__("New Character")}}
        </button>
    </div>
    @endcan

    <x-filter.characters-filter/>

    <div class="max-w-7xl mx-auto mt-10 p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($characters as $character)

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <img src="{{$character->image_url}}" alt="{{$character->name}}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{$character->name}}</h2>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{Str::limit($character->description, 50)}}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{$character->age}} year</span>
                                <div class="space-x-2">
                                    <button wire:click="show({{ $character->id }})"
                                            class="text-blue-500 hover:underline">{{__("See")}}</button>
                                    @can('update', \App\Models\Character::class)
                                    <button wire:click="edit({{ $character->id }})"
                                            class="text-yellow-500 hover:underline">{{__('Edit')}}</button>
                                    @endcan

                                    @can('delete', \App\Models\Character::class)
                                    <button wire:click="confirmDelete({{ $character->id }})"
                                            class="text-red-500 hover:underline">{{__("Delete")}}</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>

            @endforeach
    </div>

    <div class="d-flex m-3 px-6 justify-content-center">
            {{ $characters->links() }}
    </div>

    {{-- Modal Crear / Editar --}}
    @if($FormModal)
        @include('modals.form-modal-character')
    @endif

    {{-- Modal Mostrar --}}
    @if ($ShowModal && $currentCharacter)
        @include('modals.show-modal-character')
    @endif

    {{-- Modal Confirmar Eliminación --}}
    @if ($DeleteModal && $currentCharacter)
        @include('modals.delete-modal-character')
    @endif
</div>
