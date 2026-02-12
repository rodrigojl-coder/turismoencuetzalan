<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    // Mostrar todos los negocios por categoría
    public function index()
    {
        $businesses = Business::where('is_active', true)->get();
        
        // Agrupar por tipo
        $categories = $businesses->groupBy('type');
        
        return view('public.negocios.index', compact('categories'));
    }

    // Mostrar negocios de una categoría específica
    public function category($type)
    {
        $businesses = Business::where('is_active', true)
                              ->where('type', $type)
                              ->get();
        
        return view('public.negocios.category', compact('type', 'businesses'));
    }

    // Mostrar detalle de un negocio específico
    public function show($slug)
    {
        $negocio = Business::where('slug', $slug)
                           ->where('is_active', true)
                           ->firstOrFail();
        
        $items = $negocio->items()->where('is_active', true)->get();
        
        return view('public.negocios.show', compact('negocio', 'items'));
    }
}
