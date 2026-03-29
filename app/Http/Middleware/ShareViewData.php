<?php

namespace App\Http\Middleware;

use App\Models\Sucursal;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

        // Sucursales activas para el footer — se cachean 10 minutos.
        $sucursalesFooter = Cache::remember('sucursales_footer', 600, fn () => Sucursal::where('activa', true)->orderBy('nombre')->get(['nombre', 'horario', 'telefono', 'direccion'])
        );

        View::share('sucursalesFooter', $sucursalesFooter);

        return $next($request);
    }
}
