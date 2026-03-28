<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Producto;
use App\Models\Talla;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1 query para las 3 estadísticas de productos (en vez de 3 separadas)
        $productoStats = Producto::selectRaw('
            COUNT(*) as total,
            SUM(activo = 1) as activos,
            SUM(oferta = 1) as en_oferta
        ')->first();

        // 1 query para los conteos de catálogos auxiliares
        $auxStats = DB::selectOne('
            SELECT
                (SELECT COUNT(*) FROM categorias) AS categorias,
                (SELECT COUNT(*) FROM tallas)     AS tallas,
                (SELECT COUNT(*) FROM colores)    AS colores
        ');

        $stats = [
            'productos'        => $productoStats->total,
            'activos'          => $productoStats->activos,
            'enOferta'         => $productoStats->en_oferta,
            'categorias'       => $auxStats->categorias,
            'tallas'           => $auxStats->tallas,
            'colores'          => $auxStats->colores,
            'ultimosProductos' => Producto::with('categorias')->latest()->limit(8)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
