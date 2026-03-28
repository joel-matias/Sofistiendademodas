<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class SitemapController extends Controller
{
    /**
     * Genera el sitemap.xml dinámico con todas las URLs indexables del sitio.
     * Se excluyen rutas de admin, auth y filtros de UX para no desperdiciar crawl budget.
     */
    public function index()
    {
        $productos  = Producto::where('activo', true)
            ->orderByDesc('updated_at')
            ->get(['slug', 'updated_at']);

        $categorias = Categoria::orderBy('nombre')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('productos', 'categorias'))
            ->header('Content-Type', 'application/xml');
    }
}
