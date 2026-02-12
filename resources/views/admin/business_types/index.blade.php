<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900">Tipos de Negocio</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <a href="{{ route('business-types.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">Nuevo tipo</a>

            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="text-left">Nombre</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                        <tr>
                            <td>{{ $type->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('business-types.edit', $type) }}" class="px-2 py-1 bg-yellow-400 text-white rounded">Editar</a>
                                <form action="{{ route('business-types.destroy', $type) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button class="px-2 py-1 bg-red-600 text-white rounded">Eliminar</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
