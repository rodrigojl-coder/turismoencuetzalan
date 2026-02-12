<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">Agregar Ítem</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow sm:rounded-lg p-6">
            <form action="{{ route('propietario.negocios.items.store', $negocio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Tipo de ítem</label>
                    <select name="type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900" required>
                    @foreach($typeOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Nombre</label>
                    <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Descripción</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-medium text-gray-900">Precio temporada baja</label>
                        <input type="number" name="price_low" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-900">Precio temporada alta</label>
                        <input type="number" name="price_high" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Cantidad / N° de habitaciones</label>
                    <input type="number" name="quantity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Imágenes</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                    <p class="text-xs text-gray-600 mt-1">Máx 5MB por imagen.</p>
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                        <span class="text-gray-900">Publicar ítem</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('propietario.negocios.items.index', $negocio) }}" class="px-4 py-2 bg-gray-300 text-gray-900 rounded hover:bg-gray-400">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
