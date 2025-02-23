<div class="container mx-auto py-8 px-6">
    <h1 class="text-4xl font-extrabold text-purple-600 text-center mb-4">Dashboard</h1>
        <form action="{{ route('dashboard.deleteArchivedPosts') }}" method="POST">
        @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 mb-2">
                🗑️ Eliminar Posts Archivados de +5 Años
            </button>
        </form>

        @if(session('status'))
            <p x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="mb-2 text-white bg-violet-800 transition-opacity duration-500 ease-in-out animate-fade-in">{{ session('status') }}</p>
       @endif

        <!-- Estadísticas Generales -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">📌 Publicaciones</h2>
                <p class="text-4xl font-extrabold">50</p>
            </div>
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">💬 Comentarios</h2>
                <p class="text-4xl font-extrabold">100</p>
            </div>
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">👥 Usuarios</h2>
                <p class="text-4xl font-extrabold">10</p>
            </div>
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">🖊️ Tus Posts</h2>
                <p class="text-4xl font-extrabold">5</p>
            </div>
        </div>

        <!-- Gestión de Contenido -->
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-purple-800 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3">📝 Gestionar Publicaciones</h2>
                <p class="text-sm text-purple-200">Administra las publicaciones existentes o crea nuevas.</p>
                <a href="{{ route('forum.my-posts') }}" class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    Ver mis publicaciones →
                </a>
            </div>

            <div class="bg-purple-800 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3">💬 Gestionar Comentarios</h2>
                <p class="text-sm text-purple-200">Revisa y modera los comentarios realizados en la plataforma.</p>
                <a href="{{ route('comments.my-comments') }}" class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    Ver mis comentarios →
                </a>
            </div>
        </div>
    </div>
