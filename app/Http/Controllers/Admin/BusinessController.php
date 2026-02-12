<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::with('user')->latest()->get();

        return view('admin.business.index', compact('businesses'));
    }

    public function toggle(Business $business)
    {
        $business->update([
            'is_active' => ! $business->is_active
        ]);

        return back()->with('success', 'Estado del negocio actualizado');
    }
}
