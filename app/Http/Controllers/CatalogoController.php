<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function catalogo()
    {

        $productos = [
            [
                'nombre' => 'Camisa Oversize',
                'precio' => 499,
                'slug' => 'camisa-oversize',
                'imagen' => 'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Camisas',
            ],
            [
                'nombre' => 'Sudadera Minimal',
                'precio' => 699,
                'slug' => 'sudadera-minimal',
                'imagen' => 'https://images.unsplash.com/photo-1520975682031-a0e27ecf41f0?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Sudaderas',
            ],
            [
                'nombre' => 'Pantalón Cargo',
                'precio' => 799,
                'slug' => 'pantalon-cargo',
                'imagen' => 'https://images.unsplash.com/photo-1514997130083-3e48bd2b2b86?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Pantalones',
            ],
            [
                'nombre' => 'Vestido Casual',
                'precio' => 899,
                'slug' => 'vestido-casual',
                'imagen' => 'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Vestidos',
            ],
        ];

        return view('catalogo.index', compact('productos'));
    }

    public function producto($slug)
    {
        // dummy data
        $producto = [
            'nombre' => 'Camisa Oversize',
            'precio' => 499,
            'slug' => $slug,
            'descripcion' => 'Camisa oversize de algodón premium, cómoda y perfecta para looks casuales.',
            'imagen' => 'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
            'categoria' => 'Camisas',
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
