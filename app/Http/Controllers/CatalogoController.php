<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
{
    /**
     * Convierte una ruta guardada en BD a URL pública.
     * - Si ya es URL (http/https) la deja igual.
     * - Si es ruta local (productos/xxx.png) la convierte a /storage/...
     */
    private function urlImagen(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'http')
            ? $path
            : Storage::url($path);
    }

    public function home()
    {
        $categorias = Categoria::all()->map(function ($c) {
            return [
                'titulo' => $c->nombre,
                'img' => $this->urlImagen($c->imagen) ?? asset('assets/img/placeholder-category.jpg'),
                'nombre' => $c->nombre,
                'imagen' => $this->urlImagen($c->imagen) ?? asset('assets/img/placeholder-category.jpg'),
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
                    'imagen' => $this->urlImagen($p->imagen),

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
        if ($request->boolean('ofertas')) {
            $query->where('oferta', true);
        }
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
                'imagen' => $this->urlImagen($p->imagen),

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
        $p = Producto::with(['categorias', 'imagenes', 'tallas', 'colores', 'detalles'])
            ->where('slug', $slug)
            ->firstOrFail();

        // ✅ Armamos listado de imágenes (principal + galería) máximo 4
        $imagenes = [];

        if (! empty($p->imagen)) {
            $imagenes[] = $this->urlImagen($p->imagen);
        }

        foreach ($p->imagenes as $img) {
            if (count($imagenes) >= 4) {
                break;
            }
            $imagenes[] = $this->urlImagen($img->url);
        }

        // ✅ Categorías
        $categorias = $p->categorias->map(fn ($c) => [
            'id' => $c->id,
            'nombre' => $c->nombre,
            'slug' => $c->slug,
        ])->values()->toArray();

        // ✅ Detalles
        $detalles = $p->detalles->sortBy('orden')->pluck('texto')->values()->toArray();

        // ✅ Tallas
        $tallas = $p->tallas->pluck('nombre')->values()->toArray();

        // ✅ Colores (con hex)
        $colores = $p->colores->map(fn ($c) => [
            'nombre' => $c->nombre,
            'hex' => $c->hex,
        ])->values()->toArray();

        $producto = [
            'id' => $p->id,
            'nombre' => $p->nombre,
            'precio' => $p->precio,
            'slug' => $p->slug,
            'descripcion' => $p->descripcion,

            // ✅ principal y galería
            'imagen' => $imagenes[0] ?? $this->urlImagen($p->imagen),
            'imagenes' => $imagenes,

            'oferta' => (bool) $p->oferta,
            'precio_oferta' => $p->precio_oferta,

            // Para mostrar en badge:
            'categoria' => $p->categorias->first()?->nombre ?? '',
            // Para "también te puede gustar":
            'categorias' => $categorias,

            'tallas' => $tallas,
            'colores' => $colores,
            'detalles' => $detalles,
        ];

        // ✅ Recomendados por categorías (mismas categorías)
        $categoriaIds = $p->categorias->pluck('id')->toArray();

        $recomendados = Producto::with('categorias')
            ->where('activo', true)
            ->where('id', '!=', $p->id)
            ->whereHas('categorias', function ($q) use ($categoriaIds) {
                $q->whereIn('categorias.id', $categoriaIds);
            })
            ->latest()
            ->limit(8)
            ->get()
            ->map(function ($rp) {
                $catPrincipal = $rp->categorias->first();

                return [
                    'nombre' => $rp->nombre,
                    'precio' => $rp->precio,
                    'slug' => $rp->slug,
                    'imagen' => $this->urlImagen($rp->imagen),
                    'categoria' => $catPrincipal?->nombre ?? '',
                    'categorias' => $rp->categorias->pluck('nombre')->implode(', '),
                    'oferta' => (bool) $rp->oferta,
                    'precio_oferta' => $rp->precio_oferta,
                ];
            })->toArray();

        return view('catalogo.show', compact('producto', 'recomendados'));
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
