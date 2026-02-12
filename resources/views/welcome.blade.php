<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Turismo en Cuetzalan - Hospedajes, Restaurantes y Más</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-gray-900">
        <!-- Navegación -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <div class="text-2xl font-bold text-blue-600"> Cuetzalan</div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('negocios.index') }}" class="text-gray-700 hover:text-blue-600 font-semibold">
                        Explorar Negocios
                    </a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Salir</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Ingresar</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-4">Bienvenido a Turismo en Cuetzalan</h1>
                <p class="text-xl mb-8 text-blue-100">
                    Descubre los mejores hospedajes, restaurantes y experiencias locales
                </p>
                <a href="{{ route('negocios.index') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                    Explorar Ahora 
                </a>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Hospedajes -->
                <div class="text-center">
                    <div class="text-6xl mb-4"></div>
                    <h2 class="text-2xl font-bold mb-2">Hospedajes</h2>
                    <p class="text-gray-600 mb-4">
                        Hoteles, cabañas y hostales cómodos para tu descanso
                    </p>
                    <a href="{{ route('negocios.category', 'hotel') }}" class="text-blue-600 font-semibold hover:underline">
                        Ver hospedajes 
                    </a>
                </div>

                <!-- Gastronomía -->
                <div class="text-center">
                    <div class="text-6xl mb-4"></div>
                    <h2 class="text-2xl font-bold mb-2">Gastronomía</h2>
                    <p class="text-gray-600 mb-4">
                        Restaurantes y cafeterías con deliciosa comida local
                    </p>
                    <a href="{{ route('negocios.category', 'restaurante') }}" class="text-blue-600 font-semibold hover:underline">
                        Ver restaurantes 
                    </a>
                </div>

                <!-- Experiencias -->
                <div class="text-center">
                    <div class="text-6xl mb-4"></div>
                    <h2 class="text-2xl font-bold mb-2">Más Experiencias</h2>
                    <p class="text-gray-600 mb-4">
                        Descubre otros servicios y actividades locales
                    </p>
                    <a href="{{ route('negocios.index') }}" class="text-blue-600 font-semibold hover:underline">
                        Ver todas las categorías 
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-100 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Turismo en Cuetzalan. Todos los derechos reservados.</p>
            </div>
        </footer>
    </body>
</html>
