<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel del Propietario
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Mis negocios -->
            <a href="{{ route('propietario.negocios.index') }}"
               class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                <h3 class="text-lg font-bold">🏨 Mis Negocios</h3>
                <p class="text-gray-600 mt-2">
                    Administra hoteles, cabañas, restaurantes y más
                </p>
            </a>

            <!-- Crear negocio -->
            <a href="{{ route('propietario.negocios.create') }}"
               class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                <h3 class="text-lg font-bold">➕ Nuevo Negocio</h3>
                <p class="text-gray-600 mt-2">
                    Registra un nuevo negocio para publicarlo
                </p>
            </a>

            <!-- Próximamente -->
            <div class="block p-6 bg-gray-100 shadow rounded-lg opacity-60">
                <h3 class="text-lg font-bold">📅 Reservas (próximamente)</h3>
                <p class="text-gray-600 mt-2">
                    Gestión de disponibilidad y fechas
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
