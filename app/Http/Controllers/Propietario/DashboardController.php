<?php

namespace App\Http\Controllers\Propietario;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
         $dashboardRoute = 'propietario.dashboard'; // define la ruta correcta
    return view('propietario.dashboard', compact('dashboardRoute'));
    }
}
