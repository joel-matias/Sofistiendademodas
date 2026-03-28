<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cover;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        // Categorías y covers cambian raramente → se cachean 10 minutos.
        // Se invalidan automáticamente desde los controllers admin (ver CoverController / CategoriaController).
        $categorias = Cache::remember('home_categorias', 600, function () {
            return Categoria::orderBy('nombre')->get()->map(function ($c) {
                $img = $this->urlImagen($c->imagen) ?? asset('assets/img/placeholder-category.jpg');
                return [
                    'titulo'  => $c->nombre,
                    'img'     => $img,
                    'nombre'  => $c->nombre,
                    'imagen'  => $img,
                    'slug'    => $c->slug,
                ];
            })->toArray();
        });

        $covers = Cache::remember('home_covers', 600, function () {
            return Cover::activos()->get()->map(function ($c) {
                return [
                    'titulo'      => $c->titulo,
                    'subtitulo'   => $c->subtitulo,
                    'texto_boton' => $c->texto_boton,
                    'url_boton'   => $c->url_boton,
                    'imagen'      => $c->imagen
                        ? (str_starts_with($c->imagen, 'http') ? $c->imagen : Storage::url($c->imagen))
                        : null,
                ];
            })->toArray();
        });

        // Productos destacados: cambian con más frecuencia → caché de 5 minutos
        $destacados = Cache::remember('home_destacados', 300, function () {
            return Producto::with(['categorias', 'imagenes'])
                ->where('activo', true)
                ->orderByDesc('created_at')
                ->limit(10)
                ->get()
                ->map(function ($p) {
                    $categoriaPrincipal = $p->categorias->first();
                    $imagenHover = $p->imagenes->isNotEmpty()
                        ? $this->urlImagen($p->imagenes->first()->url)
                        : null;

                    return [
                        'id'           => $p->id,
                        'nombre'       => $p->nombre,
                        'precio'       => $p->precio,
                        'slug'         => $p->slug,
                        'descripcion'  => $p->descripcion,
                        'imagen'       => $this->urlImagen($p->imagen),
                        'imagen_hover' => $imagenHover,
                        'categoria'    => $categoriaPrincipal ? $categoriaPrincipal->nombre : '',
                        'categorias'   => $p->categorias->pluck('nombre')->implode(', '),
                        'oferta'       => (bool) $p->oferta,
                        'precio_oferta' => $p->precio_oferta,
                    ];
                })->toArray();
        });

        return view('home', compact('categorias', 'destacados', 'covers'));
    }

    public function catalogo(Request $request)
    {
        $categoriaSlug = $request->query('categoria');

        $query = Producto::with(['categorias', 'imagenes'])->where('activo', true);
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
            $imagenHover = $p->imagenes->isNotEmpty()
                ? $this->urlImagen($p->imagenes->first()->url)
                : null;

            return [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'precio' => $p->precio,
                'slug' => $p->slug,
                'imagen' => $this->urlImagen($p->imagen),
                'imagen_hover' => $imagenHover,
                'categoria' => $categoriaPrincipal ? $categoriaPrincipal->nombre : '',
                'categorias' => $p->categorias->pluck('nombre')->implode(', '),
                'oferta' => (bool) $p->oferta,
                'precio_oferta' => $p->precio_oferta,
            ];
        });

        return view('catalogo.index', compact('productos', 'categoriaSeleccionada'));
    }

    public function sugerenciasBusqueda(Request $request)
    {
        // Limitar longitud del término para evitar queries LIKE excesivamente largas
        $q = mb_substr(trim((string) $request->query('q', '')), 0, 100);

        if (mb_strlen($q) < 2) {
            return response()->json(['terminos' => [], 'productos' => [], 'total' => 0]);
        }

        $where = fn($query) => $query
            ->where('nombre', 'like', "%{$q}%")
            ->orWhere('descripcion', 'like', "%{$q}%");

        // Query 1: conteo total de coincidencias
        $total = Producto::where('activo', true)->where($where)->count();

        // Query 2: productos (top 5) → los primeros 4 se muestran como cards,
        // sus nombres sirven como términos sugeridos (evita una 3ª query separada)
        $resultados = Producto::where('activo', true)
            ->where($where)
            ->orderBy('nombre')
            ->limit(5)
            ->get(['id', 'nombre', 'slug', 'imagen', 'precio', 'oferta', 'precio_oferta']);

        $terminos = $resultados->pluck('nombre')->values()->toArray();

        $productos = $resultados->take(4)->map(function ($p) {
            return [
                'nombre'        => $p->nombre,
                'slug'          => $p->slug,
                'imagen'        => $this->urlImagen($p->imagen),
                'precio'        => $p->precio,
                'oferta'        => (bool) $p->oferta,
                'precio_oferta' => $p->precio_oferta,
                'url'           => route('producto', $p->slug),
            ];
        });

        return response()->json([
            'terminos' => $terminos,
            'productos' => $productos,
            'total'    => $total,
        ]);
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

        $categorias = $p->categorias->map(fn ($c) => [
            'id' => $c->id,
            'nombre' => $c->nombre,
            'slug' => $c->slug,
        ])->values()->toArray();

        $detalles = $p->detalles->sortBy('orden')->pluck('texto')->values()->toArray();

        $tallas = $p->tallas->pluck('nombre')->values()->toArray();

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

        $recomendados = Producto::with(['categorias', 'imagenes'])
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
                $imagenHover = $rp->imagenes->isNotEmpty()
                    ? $this->urlImagen($rp->imagenes->first()->url)
                    : null;

                return [
                    'id' => $rp->id,
                    'nombre' => $rp->nombre,
                    'precio' => $rp->precio,
                    'slug' => $rp->slug,
                    'imagen' => $this->urlImagen($rp->imagen),
                    'imagen_hover' => $imagenHover,
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
