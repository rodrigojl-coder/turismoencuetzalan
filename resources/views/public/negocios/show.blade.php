@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center space-x-2 text-gray-600">
                <a href="{{ route('negocios.index') }}" class="hover:text-blue-600">Categorías</a>
                <span>→</span>
                <a href="{{ route('negocios.category', $negocio->type) }}" class="hover:text-blue-600 capitalize">{{ $negocio->type }}</a>
                <span>→</span>
                <span class="text-gray-900 font-semibold">{{ $negocio->name }}</span>
            </div>
        </div>
    </div>

    <!-- Galería de imágenes -->
    <div class="relative bg-gray-900">
        <div class="max-w-7xl mx-auto">
            @if($negocio->images && count($negocio->images) > 0)
                <div class="flex flex-col lg:flex-row gap-4 p-4">
                    <!-- Imagen principal (featured first) -->
                    <div class="lg:w-2/3">
                        <img id="mainImage" 
                             src="{{ asset('storage/' . $negocio->getFeaturedImage()) }}" 
                             alt="{{ $negocio->name }}"
                             class="w-full h-96 object-cover rounded-lg">
                    </div>

                    <!-- Miniaturas -->
                    <div class="lg:w-1/3 flex lg:flex-col gap-2 overflow-x-auto lg:overflow-x-visible">
                        @foreach($negocio->images as $index => $image)
                            <button onclick="document.getElementById('mainImage').src = '{{ asset('storage/' . $image) }}';"
                                    class="flex-shrink-0 h-20 w-20 lg:h-24 lg:w-full rounded border-2 hover:border-blue-500 transition {{ $index === $negocio->featured_image_index ? 'border-blue-500' : 'border-gray-400' }}">
                                <img src="{{ asset('storage/' . $image) }}" alt="Imagen {{ $index + 1 }}" class="w-full h-full object-cover rounded">
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="w-full h-96 bg-gray-700 flex items-center justify-center rounded">
                    <span class="text-6xl text-gray-500">📷</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Información del negocio -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detalles principales -->
            <div class="lg:col-span-2">
                <h1 class="text-4xl font-bold text-gray-900">{{ $negocio->name }}</h1>
                
                <div class="flex flex-wrap gap-4 mt-4">
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold capitalize">
                        {{ $negocio->type }}
                    </span>
                    @if($negocio->is_active)
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            ✓ Abierto
                        </span>
                    @endif
                </div>

                @if($negocio->description)
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Descripción</h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $negocio->description }}</p>
                    </div>
                @endif

                <!-- Items / Servicios -->
                @if($items->count() > 0)
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ ucfirst($negocio->type) === 'Restaurante' ? 'Menú' : 'Servicios' }}</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($items as $item)
                                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition">
                                    @if($item->getFeaturedImage())
                                        <div class="h-40 overflow-hidden rounded mb-4">
                                            <img src="{{ asset('storage/' . $item->getFeaturedImage()) }}" 
                                                 alt="{{ $item->name }}" 
                                                 class="w-full h-full object-cover hover:scale-105 transition">
                                        </div>
                                    @else
                                        <div class="h-40 bg-gray-300 rounded mb-4 flex items-center justify-center">
                                            <span class="text-2xl">📷</span>
                                        </div>
                                    @endif

                                    <h3 class="text-lg font-bold text-gray-900">{{ $item->name }}</h3>
                                    
                                    @if($item->description)
                                        <p class="text-gray-600 text-sm mt-2">{{ Str::limit($item->description, 100) }}</p>
                                    @endif

                                    @if($item->price_low || $item->price_high)
                                        <p class="text-blue-600 font-bold mt-3">
                                            @if($item->price_low && $item->price_high)
                                                ${{ number_format($item->price_low, 2) }} - ${{ number_format($item->price_high, 2) }}
                                            @elseif($item->price_low)
                                                Desde ${{ number_format($item->price_low, 2) }}
                                            @else
                                                Hasta ${{ number_format($item->price_high, 2) }}
                                            @endif
                                        </p>
                                    @endif

                                    @if($item->type)
                                        <p class="text-gray-500 text-sm mt-2 capitalize">{{ $item->type }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Barra lateral de contacto -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 sticky top-20">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Contacto</h3>

                    @if($negocio->phone)
                        <div class="flex items-start gap-3 mb-4">
                            <span class="text-2xl">📞</span>
                            <div>
                                <p class="text-sm text-gray-600">Teléfono</p>
                                <a href="tel:{{ $negocio->phone }}" class="text-blue-600 font-semibold hover:underline">
                                    {{ $negocio->phone }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($negocio->email)
                        <div class="flex items-start gap-3 mb-4">
                            <span class="text-2xl">✉️</span>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <a href="mailto:{{ $negocio->email }}" class="text-blue-600 font-semibold hover:underline break-all">
                                    {{ $negocio->email }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($negocio->address)
                        <div class="flex items-start gap-3 mb-4">
                            <span class="text-2xl">📍</span>
                            <div>
                                <p class="text-sm text-gray-600">Dirección</p>
                                <p class="text-gray-900 font-semibold">{{ $negocio->address }}</p>
                            </div>
                        </div>
                    @endif

                    @if($negocio->website)
                        <div class="flex items-start gap-3 mb-4">
                            <span class="text-2xl">🌐</span>
                            <div>
                                <p class="text-sm text-gray-600">Sitio web</p>
                                <a href="{{ $negocio->website }}" target="_blank" rel="noopener noreferrer" 
                                   class="text-blue-600 font-semibold hover:underline break-all">
                                    Visitar
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($negocio->price_from)
                        <div class="border-t border-blue-200 mt-4 pt-4">
                            <p class="text-sm text-gray-600">Rango de precios</p>
                            <p class="text-2xl font-bold text-blue-600">Desde ${{ $negocio->price_from }}</p>
                        </div>
                    @endif

                    <div class="border-t border-blue-200 mt-6 pt-4">
                        <a href="{{ route('negocios.index') }}" class="inline-block w-full bg-blue-600 text-white text-center px-4 py-2 rounded hover:bg-blue-700 transition">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
