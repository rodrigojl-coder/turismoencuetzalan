@extends('admin')

@section('title', 'Negocios')

@section('content')
<h1 class="text-2xl font-bold mb-4">Negocios Registrados</h1>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

<table class="w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-2">Nombre</th>
            <th class="p-2">Propietario</th>
            <th class="p-2">Tipo</th>
            <th class="p-2">Estado</th>
            <th class="p-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($businesses as $business)
        <tr class="border-b">
            <td class="p-2">{{ $business->name }}</td>
            <td class="p-2">{{ $business->user->name }}</td>
            <td class="p-2 capitalize">{{ $business->type }}</td>
            <td class="p-2">
                @if($business->is_active)
                    <span class="text-green-600 font-bold">Aprobado</span>
                @else
                    <span class="text-red-600 font-bold">Pendiente</span>
                @endif
            </td>
            <td class="p-2">
                <form method="POST" action="{{ route('business.toggle', $business) }}">
                    @csrf
                    @method('PATCH')
                    <button class="px-2 py-1 rounded
                        @if($business->is_active)
                            bg-red-500 text-white hover:bg-red-600
                        @else
                            bg-green-500 text-white hover:bg-green-600
                        @endif
                    ">
                        @if($business->is_active)
                            Desaprobar
                        @else
                            Aprobar
                        @endif
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
