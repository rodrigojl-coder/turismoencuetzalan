<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            Ítems del negocio: {{ $negocio->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('propietario.negocios.items.create', $negocio) }}" 
           class="mb-6 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
           Agregar ítem
        </a>

        @if($items->isEmpty())
            <p class="text-gray-500">No hay ítems disponibles para este negocio.</p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($items as $item)
                <div class="bg-white border rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-200">
                    @if($item->images && count($item->images))
                        <img src="{{ asset('storage/'.$item->images[0]) }}" class="h-48 w-full object-cover" alt="{{ $item->name }}">
                    @else
                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-500">Sin imagen</div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $item->name }}</h3>
                        @if($item->price_low || $item->price_high)
                            <p class="text-gray-700">
                                @if($item->price_low)
                                    Baja: ${{ $item->price_low }}
                                @endif
                                @if($item->price_high)
                                    | Alta: ${{ $item->price_high }}
                                @endif
                            </p>
                        @endif
                        <p class="text-sm text-gray-600">{{ ucfirst($item->type) }}</p>
                        <p class="mt-1">
                            @if($item->is_active)
                                <span class="text-green-600 font-bold">Activo</span>
                            @else
                                <span class="text-red-600 font-bold">Desactivado</span>
                            @endif
                        </p>
                        <div class="mt-3 flex space-x-2">
                            <a href="{{ route('propietario.negocios.items.edit', [$negocio, $item]) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                            <form action="{{ route('propietario.negocios.items.destroy', [$negocio, $item]) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este ítem?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
