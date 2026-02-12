<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            Crear Nuevo Negocio
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
            <form action="{{ route('propietario.negocios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Nombre del negocio</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Tipo</label>
                    <select name="business_type_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                        <option value="">Selecciona...</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('business_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Descripción</label>
                    <textarea name="description" rows="4"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Precio desde</label>
                    <input type="number" step="0.01" name="price_from" value="{{ old('price_from') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900">
                </div>

                <!-- Campos de contacto -->
                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900"
                           placeholder="Ej: +52 123 456 7890">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900"
                           placeholder="contacto@negocio.com">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Dirección</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900"
                           placeholder="Calle y número">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Sitio Web</label>
                    <input type="url" name="website" value="{{ old('website') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900"
                           placeholder="https://tunegocio.com">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-900">Imágenes del negocio</label>
                    <input type="file" name="images[]" multiple
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-white text-gray-900"
                        accept="image/*">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('propietario.negocios.index') }}"
                       class="px-4 py-2 bg-gray-300 text-gray-900 rounded hover:bg-gray-400">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Crear</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
