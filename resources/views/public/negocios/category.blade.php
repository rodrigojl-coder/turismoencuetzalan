@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Header con breadcrumb -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center space-x-2 text-blue-100 mb-4">
                <a href="{{ route('negocios.index') }}" class="hover:text-white">Categorías</a>
                <span>→</span>
                <span>{{ ucfirst($type) }}</span>
            </div>
            <h1 class="text-4xl font-bold text-white">{{ ucfirst($type) }}</h1>
        </div>
    </div>

    <!-- Contenido -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        @if($businesses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($businesses as $negocio)
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
                                
                                @if($negocio->description)
                                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $negocio->description }}</p>
                                @endif

                                @if($negocio->price_from)
                                    <p class="text-blue-600 font-bold mt-2">Desde ${{ $negocio->price_from }}</p>
                                @endif

                                @if($negocio->phone)
                                    <p class="text-gray-600 text-sm mt-2">📞 {{ $negocio->phone }}</p>
                                @endif

                                <div class="mt-4 inline-block text-blue-600 group-hover:translate-x-1 transition">
                                    Ver detalles →
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-xl">No hay {{ strtolower($type) }}s disponibles en este momento</p>
                <a href="{{ route('negocios.index') }}" class="inline-block mt-6 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Volver a categorías
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
