<div class="container mx-auto py-8 px-6">
        <h1 class="text-4xl font-extrabold text-purple-600 text-center mb-4">Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">📌 Publicaciones</h2>
                <p class="text-4xl font-extrabold">{{ $stats['totalPosts'] }}</p>
            </div>
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">💬 Comentarios</h2>
                <p class="text-4xl font-extrabold">{{ $stats['totalComments'] }}</p>
            </div>
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">👥 Usuarios</h2>
                <p class="text-4xl font-extrabold">{{ $stats['totalUsers'] }}</p>
            </div>
            <div class="bg-purple-900 text-white shadow-lg rounded-xl p-6 text-center">
                <h2 class="text-2xl font-bold">🖊️ Tus Posts</h2>
                <p class="text-4xl font-extrabold">{{ $stats['userPosts'] }}</p>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-purple-800 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3">📝 Gestionar Publicaciones</h2>
                <p class="text-sm text-purple-200">Administra las tus publicaciones existentes o crea nuevas.</p>
                <a href="{{ route('forum.my-posts') }}" class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    Ver mis publicaciones →
                </a>
            </div>

            <div class="bg-purple-800 text-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-xl font-semibold text-purple-300 mb-3">💬 Gestionar Comentarios</h2>
                <p class="text-sm text-purple-200">Revisa y modera tus comentarios realizados en la plataforma.</p>
                <a href="{{ route('comments.my-comments') }}" class="block mt-4 text-purple-400 font-medium hover:text-purple-200">
                    Ver mis comentarios →
                </a>
            </div>
        </div>
</div>

