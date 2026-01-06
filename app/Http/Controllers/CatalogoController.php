<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function home()
    {
        $categorias = Categoria::all()->map(function ($c) {
            return [
                'titulo' => $c->nombre,
                'img' => $c->imagen ?? asset('assets/img/placeholder-category.jpg'),
                'nombre' => $c->nombre,
                'imagen' => $c->imagen ?? asset('assets/img/placeholder-category.jpg'),
                'slug' => $c->slug,
            ];
        })->toArray();

        $destacados = Producto::with('categoria')
            ->where('activo', true)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'nombre' => $p->nombre,
                    'precio' => $p->precio,
                    'slug' => $p->slug,
                    'descripcion' => $p->descripcion,
                    'imagen' => $p->imagen,
                    'categoria' => $p->categoria ? $p->categoria->nombre : '',
                    'oferta' => (bool) $p->oferta,
                    'precio_oferta' => $p->precio_oferta,
                ];
            })->toArray();

        return view('home', compact('categorias', 'destacados'));
    }

    public function catalogo(Request $request)
    {
        $categoriaSlug = $request->query('categoria');

        $query = Producto::with('categoria')->where('activo', true);
        $categoriaSeleccionada = null;

        if ($categoriaSlug) {
            // intentamos por slug primero
            $categoria = Categoria::where('slug', $categoriaSlug)->first();

            // si no hay slug, intentamos por nombre (para mayor tolerancia)
            if (! $categoria) {
                $nombre = str_replace('-', ' ', $categoriaSlug);
                $categoria = Categoria::whereRaw('LOWER(nombre) = ?', [strtolower($nombre)])->first();
            }

            if ($categoria) {
                $categoriaSeleccionada = [
                    'nombre' => $categoria->nombre,
                    'slug' => $categoria->slug,
                ];
                $query->where('categoria_id', $categoria->id);
            }
        }

        // Filtro de búsqueda (opcional)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Orden (ejemplo sencillo: precio_menor, precio_mayor, por defecto: nuevos)
        $orden = $request->input('orden');
        if ($orden === 'precio_menor') {
            $query->orderBy('precio', 'asc');
        } elseif ($orden === 'precio_mayor') {
            $query->orderBy('precio', 'desc');
        } else {
            $query->orderByDesc('created_at');
        }

        // Paginar y mantener query string
        $productos = $query->paginate(24)->withQueryString();

        // Transformar los items a la estructura que tus vistas/ component esperan
        $productos->getCollection()->transform(function ($p) {
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

        return view('catalogo.index', compact('productos', 'categoriaSeleccionada'));
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
