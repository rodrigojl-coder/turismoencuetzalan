<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    public function index()
    {
        $types = BusinessType::orderBy('name')->get();
        return view('admin.business_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.business_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_types,name'
        ]);

        BusinessType::create([
            'name' => $request->name,
        ]);

        return redirect()->route('business-types.index')->with('success', 'Tipo creado');
    }

    public function edit(BusinessType $business_type)
    {
        return view('admin.business_types.edit', ['type' => $business_type]);
    }

    public function update(Request $request, BusinessType $business_type)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_types,name,' . $business_type->id
        ]);

        $business_type->update(['name' => $request->name]);

        return redirect()->route('business-types.index')->with('success', 'Tipo actualizado');
    }

    public function destroy(BusinessType $business_type)
    {
        $business_type->delete();
        return redirect()->route('business-types.index')->with('success', 'Tipo eliminado');
    }
}
