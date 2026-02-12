@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="text-2xl font-bold mb-4">
        Panel de Administración
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
<a href="{{ route('business.index') }}" class="bg-white p-4 rounded shadow hover:shadow-lg transition flex justify-between items-center">
        <div>
            🏨 Negocios registrados
        </div>
        <div class="bg-red-500 text-white px-2 py-1 rounded-full text-sm font-bold">
            {{ \App\Models\Business::where('is_active', 0)->count() }} pendientes
        </div>
    </a>        </div>

        <div class="bg-white p-4 rounded shadow">
            🗺️ Recorridos activos
        </div>

        <div class="bg-white p-4 rounded shadow">
            💰 Comisiones del mes
        </div>
    </div>
@endsection
