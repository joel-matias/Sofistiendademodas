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

        $destacados = Producto::with('categorias')
            ->where('activo', true)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($p) {

                $categoriaPrincipal = $p->categorias->first();

                return [
                    'nombre' => $p->nombre,
                    'precio' => $p->precio,
                    'slug' => $p->slug,
                    'descripcion' => $p->descripcion,
                    'imagen' => $p->imagen,

                    // ✅ compatibilidad con tus vistas actuales
                    'categoria' => $categoriaPrincipal ? $categoriaPrincipal->nombre : '',

                    // ✅ extra por si quieres mostrar todas
                    'categorias' => $p->categorias->pluck('nombre')->implode(', '),

                    'oferta' => (bool) $p->oferta,
                    'precio_oferta' => $p->precio_oferta,
                ];
            })->toArray();

        return view('home', compact('categorias', 'destacados'));
    }

    public function catalogo(Request $request)
    {
        $categoriaSlug = $request->query('categoria');

        $query = Producto::with('categorias')->where('activo', true);
        $categoriaSeleccionada = null;

        if ($categoriaSlug) {

            $categoria = Categoria::where('slug', $categoriaSlug)->first();

            if (! $categoria) {
                $nombre = str_replace('-', ' ', $categoriaSlug);
                $categoria = Categoria::whereRaw('LOWER(nombre) = ?', [strtolower($nombre)])->first();
            }

            if ($categoria) {
                $categoriaSeleccionada = [
                    'nombre' => $categoria->nombre,
                    'slug' => $categoria->slug,
                ];

                // ✅ filtro many-to-many
                $query->whereHas('categorias', function ($q) use ($categoria) {
                    $q->where('categorias.id', $categoria->id);
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $orden = $request->input('orden');

        if ($orden === 'precio_menor') {
            $query->orderBy('precio', 'asc');
        } elseif ($orden === 'precio_mayor') {
            $query->orderBy('precio', 'desc');
        } else {
            $query->orderByDesc('created_at');
        }

        $productos = $query->paginate(24)->withQueryString();

        $productos->getCollection()->transform(function ($p) {

            $categoriaPrincipal = $p->categorias->first();

            return [
                'nombre' => $p->nombre,
                'precio' => $p->precio,
                'slug' => $p->slug,
                'imagen' => $p->imagen,

                // ✅ compatibilidad (una sola)
                'categoria' => $categoriaPrincipal ? $categoriaPrincipal->nombre : '',

                // ✅ todas
                'categorias' => $p->categorias->pluck('nombre')->implode(', '),

                'oferta' => (bool) $p->oferta,
                'precio_oferta' => $p->precio_oferta,
            ];
        });

        return view('catalogo.index', compact('productos', 'categoriaSeleccionada'));
    }

    public function producto($slug)
    {
        $p = Producto::with('categorias')->where('slug', $slug)->firstOrFail();

        $categoriaPrincipal = $p->categorias->first();

        $producto = [
            'nombre' => $p->nombre,
            'precio' => $p->precio,
            'slug' => $p->slug,
            'descripcion' => $p->descripcion,
            'imagen' => $p->imagen,

            'categoria' => $categoriaPrincipal ? $categoriaPrincipal->nombre : '',
            'categorias' => $p->categorias->pluck('nombre')->implode(', '),

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
