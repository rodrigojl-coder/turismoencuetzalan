<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-4 text-xl font-bold border-b border-gray-700">
            Turismo en Cuetzalan
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                📊 Dashboard
            </a>

            <a href="{{ route('business.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                🏨 Negocios
            </a>

            <a href="#"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                🗺️ Recorridos
            </a>

            <a href="#"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                📰 Blog
            </a>

            <a href="#"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                💰 Comisiones
            </a>
            
            <a href="{{ route('business-types.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                ⚙️ Tipos de negocio
            </a>
        </nav>

        <!-- Usuario -->
        <div class="p-4 border-t border-gray-700">
            <div class="text-sm">{{ Auth::user()->name }}</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-400 text-sm hover:underline">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</body>
</html>
