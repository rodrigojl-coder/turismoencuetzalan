<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropietarioMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role !== 'propietario') {
        abort(403);
    }

    return $next($request);
}
    
}
