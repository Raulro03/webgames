<!-- Barra de Navegación -->
<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20"> <!-- Altura aumentada a h-20 -->
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/webgames.png') }}" alt="WebGames Logo" class="h-[50px] mr-2 rounded-2xl"> <!-- Ajusta el tamaño de la imagen aquí -->
                <a href="/" class="text-white text-lg font-bold">
                    WebGames
                </a>
            </div>
            <!-- Links de navegación (centrados) -->
            <div class="hidden md:flex space-x-4 justify-center flex-grow">
                <a href="/" class="{{ request()->is('/') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                <a href="{{route("games")}}" class="{{ request()->is('games') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Juegos</a>
                <a href="{{route("characters")}}" class="{{ request()->is('characters') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Personajes</a>
                <a href="{{route("platforms")}}" class="{{ request()->is('platforms') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Plataformas</a>
                <a href="{{route("forum")}}" class="{{ request()->is('forum') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Foro</a>
                <a href="{{route("versus")}}" class="{{ request()->is('versus') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Versus</a>
            </div>
            <!-- Botones de Login y Register -->
            <div class="hidden md:flex space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-violet-500 hover:bg-violet-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Register
                </a>
            </div>
        </div>
    </div>
</nav>
