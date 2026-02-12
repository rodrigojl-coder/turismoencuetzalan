
<x-app-layout>
    <h2 class="text-xl font-bold mb-4">Registrar negocio</h2>

    <form method="POST" action="{{ route('propietario.business.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nombre" required>

        <select name="type">
            <option value="hotel">Hotel</option>
            <option value="cabaña">Cabaña</option>
            <option value="hostal">Hostal</option>
            <option value="restaurante">Restaurante</option>
            <option value="cafeteria">Cafetería</option>
            <option value="otro">Otro</option>
        </select>

        <textarea name="description" placeholder="Descripción"></textarea>

        <input type="number" step="0.01" name="price_from" placeholder="Precio desde">

        <button type="submit">Guardar</button>
    </form>
</x-app-layout>
