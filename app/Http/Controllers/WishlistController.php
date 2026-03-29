<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WishlistController extends Controller
{
    private function urlImagen(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'http') ? $path : Storage::url($path);
    }

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('home');
        }

        $productos = Auth::user()->favoritos()
            ->with('categorias')
            ->where('activo', true)
            ->latest('favoritos.created_at')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nombre' => $p->nombre,
                    'precio' => $p->precio,
                    'slug' => $p->slug,
                    'imagen' => $this->urlImagen($p->imagen),
                    'categoria' => $p->categorias->first()?->nombre ?? '',
                    'oferta' => (bool) $p->oferta,
                    'precio_oferta' => $p->precio_oferta,
                ];
            })->toArray();

        return view('favoritos.index', compact('productos'));
    }

    public function toggle(Request $request, Producto $producto)
    {
        $user = Auth::user();

        $existing = Favorito::where('user_id', $user->id)
            ->where('producto_id', $producto->id);

        if ($existing->exists()) {
            $existing->delete();
            $esFavorito = false;
        } else {
            Favorito::create([
                'user_id' => $user->id,
                'producto_id' => $producto->id,
            ]);
            $esFavorito = true;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'favorito' => $esFavorito,
                'count' => $user->favoritos()->count(),
            ]);
        }

        return back();
    }
}
