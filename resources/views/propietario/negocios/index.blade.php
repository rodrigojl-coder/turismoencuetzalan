<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            Mis Negocios
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('propietario.negocios.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">➕ Nuevo Negocio</a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Desde</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($businesses as $negocio)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($negocio->images && count($negocio->images) > 0)
                                    <img src="{{ asset('storage/'.$negocio->images[0]) }}" class="h-12 w-12 object-cover rounded" alt="Imagen">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $negocio->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $negocio->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $negocio->price_from ? '$'.$negocio->price_from : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $negocio->is_active ? 'Activo' : 'Pendiente' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                          <a href="{{ route('propietario.negocios.items.index', $negocio) }}"
                                              class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Administrar</a>
                                          <a href="{{ route('propietario.negocios.edit', $negocio) }}"
                                              class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                                <form action="{{ route('propietario.negocios.destroy', $negocio) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                            onclick="return confirm('¿Eliminar negocio?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No tienes negocios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
