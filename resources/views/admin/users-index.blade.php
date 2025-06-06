<x-app-layout>
    <x-slot name="header">
        <h1 class="text-4xl font-bold text-purple-600 mb-6">{{__('User Management')}}</h1>
        <a href="{{ route('dashboard') }}" class="inline-block mb-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-300">{{__('Back to Dashboard')}}</a>
    </x-slot>
    <div class="container mx-auto px-6">
        @if (session('status'))
            @if(session('status'))
                <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="mb-2 text-white bg-violet-800 transition-opacity duration-500 ease-in-out animate-fade-in">{{ session('status') }}</p>
            @endif
        @endif
        <table class="w-full border-collapse bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-purple-800 text-white">
            <tr>
                <th class="p-4">{{__('ID')}}</th>
                <th class="p-4">{{__('Name')}}</th>
                <th class="p-4">{{__('Email')}}</th>
                <th class="p-4">{{__('Role')}}</th>
                <th class="p-4">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="border-b">
                    <td class="p-4">{{ $user->id }}</td>
                    <td class="p-4">{{ $user->name }}</td>
                    <td class="p-4">{{ $user->email }}</td>
                    <td class="p-4">{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td class="p-4 flex space-x-2">

                        <form action="{{ route('admin.users-make-admin', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                {{__('Make Admin')}}
                            </button>
                        </form>

                        <form action="{{ route('admin.users.make-moderator', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
                                {{__('Make Moderator')}}
                            </button>
                        </form>

                        @if ($user->hasAnyRole(['author', 'moderator']))
                            <form action="{{ route('admin.users.remove-role', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                                    {{__('Remove Role')}}
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.users-delete', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                {{__('Delete')}}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
