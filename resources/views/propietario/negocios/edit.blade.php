<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            Editar Negocio
        </h2>
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
            <form action="{{ route('propietario.negocios.update', $negocio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Nombre del negocio</label>
                    <input type="text" name="name" value="{{ old('name', $negocio->name) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Tipo</label>
                    <select name="business_type_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('business_type_id') border-red-500 @enderror">
                        <option value="">Selecciona...</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('business_type_id', $negocio->business_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('business_type_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Descripción</label>
                    <textarea name="description" rows="4"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('description') border-red-500 @enderror">{{ old('description', $negocio->description) }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Precio desde</label>
                    <input type="number" step="0.01" name="price_from" value="{{ old('price_from', $negocio->price_from) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('price_from') border-red-500 @enderror">
                    @error('price_from')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campos de contacto -->
                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone', $negocio->phone) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('phone') border-red-500 @enderror"
                           placeholder="Ej: +52 123 456 7890">
                    @error('phone')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Email</label>
                    <input type="email" name="email" value="{{ old('email', $negocio->email) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('email') border-red-500 @enderror"
                           placeholder="contacto@negocio.com">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Dirección</label>
                    <input type="text" name="address" value="{{ old('address', $negocio->address) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('address') border-red-500 @enderror"
                           placeholder="Calle y número">
                    @error('address')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Sitio Web</label>
                    <input type="url" name="website" value="{{ old('website', $negocio->website) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('website') border-red-500 @enderror"
                           placeholder="https://tunegocio.com">
                    @error('website')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mini-carrusel de imágenes existentes -->
                @if($negocio->images && count($negocio->images) > 0)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <label class="block font-medium text-gray-900 mb-2">Imágenes actuales</label>
                        <div class="flex space-x-4 overflow-x-auto">
                            @foreach($negocio->images as $index => $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/'.$image) }}" class="h-32 w-32 object-cover rounded {{ $negocio->featured_image_index === $index ? 'ring-4 ring-blue-500' : '' }}" alt="Imagen">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded transition flex items-center justify-center gap-2">
                                        <button onclick="setFeaturedImage({{ $negocio->id }}, {{ $index }})" type="button" title="Marcar como destacada" class="opacity-0 group-hover:opacity-100 bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700 transition">⭐</button>
                                        <button onclick="deleteImage({{ $negocio->id }}, {{ $index }})" type="button" title="Eliminar" class="opacity-0 group-hover:opacity-100 bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700 transition">✕</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Subir nuevas imágenes -->
                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Imágenes del negocio</label>
                    <input type="file" name="images[]" multiple
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900 @error('images') border-red-500 @enderror"
                        accept="image/*">
                    @error('images')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('propietario.negocios.index') }}"
                       class="px-4 py-2 bg-gray-300 text-gray-900 rounded hover:bg-gray-400">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    function setFeaturedImage(negocioId, imageIndex) {
        fetch(`/propietario/negocios/${negocioId}/set-featured-image`, {
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

    function deleteImage(negocioId, imageIndex) {
        if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
            fetch(`/propietario/negocios/${negocioId}/remove-image`, {
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
