@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-white mb-2">Turismo en Cuetzalan</h1>
            <p class="text-blue-100">Descubre hospedajes, restaurantes y experiencias locales</p>
        </div>
    </div>

    <!-- Categorías -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Explora por Categoría</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Hospedajes -->
            @if(isset($categories['hotel']) || isset($categories['cabaña']) || isset($categories['hostal']))
                <a href="{{ route('negocios.category', 'hotel') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="h-48 bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center">
                            <span class="text-6xl">🏨</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600">Hospedajes</h3>
                            <p class="text-gray-600 mt-2">
                                Hoteles, cabañas y hostales para tu descanso
                            </p>
                            <div class="mt-4 flex items-center text-blue-600 group-hover:translate-x-2 transition">
                                Ver más →
                            </div>
                        </div>
                    </div>
                </a>
            @endif

            <!-- Restaurantes -->
            @if(isset($categories['restaurante']))
                <a href="{{ route('negocios.category', 'restaurante') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="h-48 bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                            <span class="text-6xl">🍽️</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600">Restaurantes</h3>
                            <p class="text-gray-600 mt-2">
                                Gastronomía local e internacional
                            </p>
                            <div class="mt-4 flex items-center text-blue-600 group-hover:translate-x-2 transition">
                                Ver más →
                            </div>
                        </div>
                    </div>
                </a>
            @endif

            <!-- Cafeterías -->
            @if(isset($categories['cafeteria']))
                <a href="{{ route('negocios.category', 'cafeteria') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="h-48 bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                            <span class="text-6xl">☕</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600">Cafeterías</h3>
                            <p class="text-gray-600 mt-2">
                                Café, postres y bebidas refrescantes
                            </p>
                            <div class="mt-4 flex items-center text-blue-600 group-hover:translate-x-2 transition">
                                Ver más →
                            </div>
                        </div>
                    </div>
                </a>
            @endif

            <!-- Otros negocios -->
            @if(isset($categories['otro']))
                <a href="{{ route('negocios.category', 'otro') }}" class="group">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                            <span class="text-6xl">🎯</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600">Otros Servicios</h3>
                            <p class="text-gray-600 mt-2">
                                Más negocios y experiencias
                            </p>
                            <div class="mt-4 flex items-center text-blue-600 group-hover:translate-x-2 transition">
                                Ver más →
                            </div>
                        </div>
                    </div>
                </a>
            @endif
        </div>

        <!-- Todos los negocios destacados -->
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Negocios Destacados</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories->flatten() as $negocio)
                <a href="{{ route('negocios.show', $negocio->slug) }}" class="group">
                    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                        <!-- Imagen destacada -->
                        @if($negocio->getFeaturedImage())
                            <div class="h-48 overflow-hidden bg-gray-200">
                                <img src="{{ asset('storage/' . $negocio->getFeaturedImage()) }}" 
                                     alt="{{ $negocio->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                        @else
                            <div class="h-48 bg-gray-300 flex items-center justify-center">
                                <span class="text-4xl">📷</span>
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600">{{ $negocio->name }}</h3>
                            <p class="text-sm text-gray-600 capitalize mt-1">{{ $negocio->type }}</p>
                            
                            @if($negocio->description)
                                <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $negocio->description }}</p>
                            @endif

                            @if($negocio->price_from)
                                <p class="text-blue-600 font-bold mt-2">Desde ${{ $negocio->price_from }}</p>
                            @endif

                            <div class="mt-4 inline-block text-blue-600 group-hover:translate-x-1 transition">
                                Ver más →
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No hay negocios disponibles en este momento</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
