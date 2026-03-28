<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareViewData
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ejecutado UNA SOLA VEZ por request (no por cada sub-vista como View::composer).
        // Comparte los IDs de productos favoritos del usuario autenticado.
        if (Auth::check() && ! Auth::user()->isAdmin()) {
            View::share('favoritoIds', Auth::user()->favoritos()->pluck('id')->toArray());
        } else {
            View::share('favoritoIds', []);
        }

        return $next($request);
    }
}
