<?php

namespace App\Http\Controllers\Propietario;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BusinessItemController extends Controller
{
    // Mostrar todos los ítems de un negocio
    public function index(Business $negocio)
    {
        $this->authorizeOwner($negocio);

        $items = $negocio->items()->latest()->get();
        return view('propietario.items.index', compact('negocio', 'items'));
    }

    // Formulario crear
    public function create(Business $negocio)
    {
        $this->authorizeOwner($negocio);

        // Definir opciones según tipo de negocio
        $typeOptions = match($negocio->type) {
            'hotel', 'cabaña', 'hostal' => ['habitacion' => 'Habitación', 'suite' => 'Suite', 'cabaña' => 'Cabaña'],
            'restaurante' => ['entrada' => 'Entrada', 'platillo' => 'Platillo', 'postre' => 'Postre', 'bebida' => 'Bebida'],
            'cafeteria' => ['bebida' => 'Bebida', 'postre' => 'Postre', 'snack' => 'Snack'],
            default => ['otro' => 'Otro'],
        };

        return view('propietario.items.create', compact('negocio', 'typeOptions'));
    }

    // Guardar
    public function store(Request $request, Business $negocio)
    {
        $this->authorizeOwner($negocio);

        $validated = $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_low' => 'nullable|numeric',
            'price_high' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
            'images.*' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('business_items', 'public');
            }
        }

        $negocio->items()->create(array_merge($validated, ['images' => $images]));

        return redirect()->route('propietario.negocios.items.index', $negocio)
                         ->with('success', 'Item creado correctamente');
    }

    // Formulario editar
    public function edit(Business $negocio, Item $item)
    {
        $this->authorizeOwner($negocio);
        return view('propietario.items.edit', compact('negocio', 'item'));
    }

    // Actualizar
    public function update(Request $request, Business $negocio, Item $item)
    {
        $this->authorizeOwner($negocio);

        $validated = $request->validate([
            'type' => 'required|in:habitacion,platillo,menu,tour_item',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_low' => 'nullable|numeric',
            'price_high' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
            'images.*' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
        ]);

        $images = $item->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('business_items', 'public');
            }
        }

        $item->update(array_merge($validated, ['images' => $images]));

        return redirect()->route('propietario.negocios.items.index', $negocio)
                         ->with('success', 'Item actualizado correctamente');
    }

    // Despublicar / eliminar
    public function destroy(Business $negocio, Item $item)
    {
        $this->authorizeOwner($negocio);

        $item->delete();
        return redirect()->route('propietario.negocios.items.index', $negocio)
                         ->with('success', 'Item eliminado correctamente');
    }

    // Eliminar imagen individual
    public function removeImage(Business $negocio, Item $item, Request $request)
    {
        $this->authorizeOwner($negocio);

        $images = $item->images ?? [];
        if(isset($images[$request->image_index])) {
            Storage::disk('public')->delete($images[$request->image_index]);
            unset($images[$request->image_index]);
            $item->images = array_values($images);
            $item->save();
        }

        return back()->with('success', 'Imagen eliminada correctamente');
    }

    // Establecer imagen destacada (AJAX)
    public function setFeaturedImage(Request $request, Business $negocio, Item $item)
    {
        $this->authorizeOwner($negocio);

        $imageIndex = $request->input('image_index');

        if (!is_null($imageIndex) && isset($item->images[$imageIndex])) {
            $item->update(['featured_image_index' => $imageIndex]);
            return response()->json(['success' => true, 'message' => 'Imagen destacada establecida']);
        }

        return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 400);
    }

    // Método de autorización del propietario
    protected function authorizeOwner(Business $negocio)
    {
        if($negocio->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
