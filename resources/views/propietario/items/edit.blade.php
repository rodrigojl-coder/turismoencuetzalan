<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">Editar Ítem: {{ $item->name }}</h2>
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
            <form action="{{ route('propietario.negocios.items.update', [$negocio, $item]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Tipo de ítem</label>
                    <select name="type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900" required>
                        <option value="habitacion" {{ $item->type == 'habitacion' ? 'selected' : '' }}>Habitación</option>
                        <option value="platillo" {{ $item->type == 'platillo' ? 'selected' : '' }}>Platillo</option>
                        <option value="menu" {{ $item->type == 'menu' ? 'selected' : '' }}>Menú</option>
                        <option value="tour_item" {{ $item->type == 'tour_item' ? 'selected' : '' }}>Recorrido</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Descripción</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">{{ old('description', $item->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-medium text-gray-900">Precio temporada baja</label>
                        <input type="number" name="price_low" step="0.01" value="{{ old('price_low', $item->price_low) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-900">Precio temporada alta</label>
                        <input type="number" name="price_high" step="0.01" value="{{ old('price_high', $item->price_high) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Cantidad / N° de habitaciones</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $item->quantity) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                </div>

                @if($item->images && count($item->images))
                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                    <label class="block font-medium text-gray-900 mb-2">Imágenes actuales</label>
                    <div class="flex space-x-4 overflow-x-auto">
                        @foreach($item->images as $index => $img)
                            <div class="relative group">
                                <img src="{{ asset('storage/'.$img) }}" class="h-32 w-32 object-cover rounded {{ $item->featured_image_index === $index ? 'ring-4 ring-blue-500' : '' }}" alt="Imagen">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded transition flex items-center justify-center gap-2">
                                    <button onclick="setFeaturedImage({{ $negocio->id }}, {{ $item->id }}, {{ $index }})" type="button" title="Marcar como destacada" class="opacity-0 group-hover:opacity-100 bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700 transition">⭐</button>
                                    <button onclick="deleteImage({{ $negocio->id }}, {{ $item->id }}, {{ $index }})" type="button" title="Eliminar" class="opacity-0 group-hover:opacity-100 bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700 transition">✕</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Agregar nuevas imágenes</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }} class="mr-2">
                        <span class="text-gray-900">Publicar ítem</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('propietario.negocios.items.index', $negocio) }}" class="px-4 py-2 bg-gray-300 text-gray-900 rounded hover:bg-gray-400">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    function setFeaturedImage(negocioId, itemId, imageIndex) {
        fetch(`/propietario/negocios/${negocioId}/items/${itemId}/set-featured-image`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ image_index: imageIndex })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteImage(negocioId, itemId, imageIndex) {
        if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
            fetch(`/propietario/negocios/${negocioId}/items/${itemId}/remove-image`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ image_index: imageIndex })
            })
            .then(response => response.json())
            .then(data => {
                window.location.reload();
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
