<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class CatalogoController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function catalogo()
    {
        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->get()
            ->map(function ($p) {
                return [
                    'nombre' => $p->nombre,
                    'precio' => $p->precio,
                    'slug' => $p->slug,
                    'imagen' => $p->imagen,
                    'categoria' => $p->categoria ? $p->categoria->nombre : '',
                    'oferta' => (bool) $p->oferta,
                    'precio_oferta' => $p->precio_oferta,
                ];
            });

        return view('catalogo.index', compact('productos'));
    }

    public function producto($slug)
    {
        $p = Producto::with('categoria')->where('slug', $slug)->firstOrFail();

        $producto = [
            'nombre' => $p->nombre,
            'precio' => $p->precio,
            'slug' => $p->slug,
            'descripcion' => $p->descripcion,
            'imagen' => $p->imagen,
            'categoria' => $p->categoria ? $p->categoria->nombre : '',
            'oferta' => (bool) $p->oferta,
            'precio_oferta' => $p->precio_oferta,
        ];

        return view('catalogo.show', compact('producto'));
    }

    public function nosotros()
    {
        return view('nosotros');
    }

    public function contacto()
    {
        return view('contacto');
    }
}
