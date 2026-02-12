<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
         if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    return $next($request);
    }
}
