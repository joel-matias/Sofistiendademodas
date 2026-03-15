<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Producto;
use App\Models\Talla;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'productos'        => Producto::count(),
            'activos'          => Producto::where('activo', true)->count(),
            'enOferta'         => Producto::where('oferta', true)->count(),
            'categorias'       => Categoria::count(),
            'tallas'           => Talla::count(),
            'colores'          => Color::count(),
            'ultimosProductos' => Producto::with('categorias')
                ->latest()
                ->limit(8)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
