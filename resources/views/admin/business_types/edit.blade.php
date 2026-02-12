<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900">Editar Tipo de Negocio</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form action="{{ route('business-types.update', $type) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $type->name) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('business-types.index') }}" class="px-4 py-2 bg-gray-300 text-gray-900 rounded">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
