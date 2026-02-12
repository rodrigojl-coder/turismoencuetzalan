<?php

namespace App\Http\Controllers\Propietario;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    /**
     * Mostrar todos los negocios del propietario.
     */
    public function index()
    {
        $businesses = Business::where('user_id', auth()->id())->get();

        return view('propietario.negocios.index', compact('businesses'));
    }

    /**
     * Formulario para crear un nuevo negocio.
     */
    public function create()
    {
        $types = BusinessType::all();
        return view('propietario.negocios.create', compact('types'));
    }

    /**
     * Guardar nuevo negocio en la base de datos.
     */
    public function store(Request $request)
    {
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('negocios', 'public'); // se guardará en storage/app/public/negocios
                $images[] = $path;
            }
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'business_type_id' => 'required|exists:business_types,id',
            'description' => 'nullable|string',
            'price_from' => 'nullable|numeric',
        ]);

        Business::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'business_type_id' => $request->business_type_id,
            'type' => optional(BusinessType::find($request->business_type_id))->slug,
            'description' => $request->description,
            'price_from' => $request->price_from,
            'is_active' => false,
            'images' => $images,
        ]);

        return redirect()->route('propietario.negocios.index')
                         ->with('success', 'Negocio creado y enviado a revisión');
    }

    /**
     * Formulario para editar un negocio existente.
     */
    public function edit(Business $negocio)
    {
        $this->authorizeOwner($negocio);

        $types = BusinessType::all();
        return view('propietario.negocios.edit', compact('negocio', 'types'));
    }

    /**
     * Actualizar negocio existente.
     */
    public function update(Request $request, Business $negocio)
    {
        $this->authorizeOwner($negocio);

        // 1️⃣ Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_type_id' => 'required|exists:business_types,id',
            'description' => 'nullable|string',
            'price_from' => 'nullable|numeric',
        ]);

        // 2️⃣ Procesar imágenes
        $existingImages = $negocio->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('negocios', 'public');
                $existingImages[] = $path;
            }
        }

        // 3️⃣ Actualizar negocio
        $negocio->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'business_type_id' => $validated['business_type_id'],
            'type' => optional(BusinessType::find($validated['business_type_id']))->slug,
            'description' => $validated['description'] ?? null,
            'price_from' => $validated['price_from'] ?? null,
            'images' => $existingImages,
        ]);

        return redirect()->route('propietario.negocios.index')
                         ->with('success', 'Negocio actualizado correctamente');
    }

    /**
     * Eliminar negocio.
     */
    public function destroy(Business $negocio)
    {
        $this->authorizeOwner($negocio);

        $negocio->delete();

        return back()->with('success', 'Negocio eliminado');
    }

    /**
     * Verificar que el negocio pertenezca al usuario.
     */
    private function authorizeOwner(Business $negocio)
    {
        if ($negocio->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function removeImage(Request $request, Business $negocio)
    {
        $this->authorizeOwner($negocio);

        $images = $negocio->images ?? [];

        $index = $request->image_index;

        if(isset($images[$index])){
            // Eliminar archivo del storage
            \Storage::disk('public')->delete($images[$index]);

            // Eliminar del array
            array_splice($images, $index, 1);

            // Guardar cambios
            $negocio->images = $images;
            $negocio->save();
        }

        return back()->with('success', 'Imagen eliminada correctamente.');
    }

    // Establecer imagen destacada (AJAX)
    public function setFeaturedImage(Request $request, Business $negocio)
    {
        $this->authorizeOwner($negocio);

        $imageIndex = $request->input('image_index');

        if (!is_null($imageIndex) && isset($negocio->images[$imageIndex])) {
            $negocio->update(['featured_image_index' => $imageIndex]);
            return response()->json(['success' => true, 'message' => 'Imagen destacada establecida']);
        }

        return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 400);
    }
}
