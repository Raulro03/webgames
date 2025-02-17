<!-- Barra de Navegación -->
<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/webgames.png') }}" alt="WebGames Logo" class="h-[50px] mr-2 rounded-2xl"> <!-- Ajusta el tamaño de la imagen aquí -->
                <a href="/" class="text-white text-lg font-bold">
                    WebGames
                </a>
            </div>

            <div class="hidden md:flex space-x-4 justify-center flex-grow">
                <a href="/" class="{{ request()->is('/') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                <a href="{{route("games")}}" class="{{ request()->is('games') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Juegos</a>
                <a href="{{route("characters")}}" class="{{ request()->is('characters') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Personajes</a>
                <a href="{{route("platforms")}}" class="{{ request()->is('platforms') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Plataformas</a>
                <a href="{{route("forum")}}" class="{{ request()->is('forum') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Foro</a>
                <a href="{{route("versus")}}" class="{{ request()->is('versus') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Versus</a>
               @auth()
                    <a href="{{route("forum.my-posts")}}" class="{{ request()->is('forum.my-posts') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium">Mis Posts</a>
                @endauth
            </div>
            <!-- Botones de Login y Register o Dropdown-->
            <div class="hidden md:flex space-x-4">
                @guest
                    <!-- Botones de Login y Register para invitados -->
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-violet-500 hover:bg-violet-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Register
                    </a>
                @else
                    <div class="relative dropdown-container">
                        <button onclick="toggleDropdown()" class="flex items-center text-white px-4 py-2 rounded-md text-sm font-medium bg-gray-700 hover:bg-gray-600">
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Menú desplegable -->
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-10">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"> {{ __('Dashboard') }} </a>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
