<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Color;
use App\Models\Cover;
use App\Models\Producto;
use App\Models\Talla;
use App\Support\CacheKeys;
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
        $categorias = Cache::remember(CacheKeys::HOME_CATEGORIAS, 600, function () {
            return Categoria::orderBy('nombre')->get()->map(function ($c) {
                $img = $this->urlImagen($c->imagen) ?? asset('assets/img/placeholder-category.jpg');

                return [
                    'titulo' => $c->nombre,
                    'img' => $img,
                    'nombre' => $c->nombre,
                    'imagen' => $img,
                    'slug' => $c->slug,
                ];
            })->toArray();
        });

        $covers = Cache::remember(CacheKeys::HOME_COVERS, 600, function () {
            return Cover::activos()->get()->map(function ($c) {
                return [
                    'titulo' => $c->titulo,
                    'subtitulo' => $c->subtitulo,
                    'texto_boton' => $c->texto_boton,
                    'url_boton' => $c->url_boton,
                    'imagen' => $c->imagen
                        ? (str_starts_with($c->imagen, 'http') ? $c->imagen : Storage::url($c->imagen))
                        : null,
                ];
            })->toArray();
        });

        // Productos destacados: cambian con más frecuencia → caché de 5 minutos
        $destacados = Cache::remember(CacheKeys::HOME_DESTACADOS, 300, function () {
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
                        'id' => $p->id,
                        'nombre' => $p->nombre,
                        'precio' => $p->precio,
                        'slug' => $p->slug,
                        'descripcion' => $p->descripcion,
                        'imagen' => $this->urlImagen($p->imagen),
                        'imagen_hover' => $imagenHover,
                        'categoria' => $categoriaPrincipal ? $categoriaPrincipal->nombre : '',
                        'categorias' => $p->categorias->pluck('nombre')->implode(', '),
                        'oferta' => (bool) $p->oferta,
                        'precio_oferta' => $p->precio_oferta,
                    ];
                })->toArray();
        });

        return view('home', compact('categorias', 'destacados', 'covers'));
    }

    public function catalogo(Request $request)
    {
        // Opciones de filtro: cambian raramente → se cachean 15 minutos.
        // Se invalidan automáticamente desde TallaObserver y ColorObserver.
        $todasLasTallas = Cache::remember(CacheKeys::CATALOGO_TALLAS, 900, fn () => Talla::orderBy('nombre')->get(['id', 'nombre', 'slug'])
        );
        $todosLosColores = Cache::remember(CacheKeys::CATALOGO_COLORES, 900, fn () => Color::orderBy('nombre')->get(['id', 'nombre', 'slug', 'hex'])
        );

        $query = Producto::with(['categorias', 'imagenes'])->where('activo', true);

        // Filtro: ofertas
        if ($request->boolean('ofertas')) {
            $query->where('oferta', true);
        }

        // Filtro: nuevo — productos de los últimos 30 días
        if ($request->boolean('nuevo')) {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        // Filtro: categoría (many-to-many)
        $categoriaSeleccionada = null;
        if ($categoriaSlug = $request->query('categoria')) {
            $categoria = Categoria::where('slug', $categoriaSlug)->first();
            if (! $categoria) {
                $nombre = str_replace('-', ' ', $categoriaSlug);
                $categoria = Categoria::whereRaw('LOWER(nombre) = ?', [strtolower($nombre)])->first();
            }
            if ($categoria) {
                $categoriaSeleccionada = ['nombre' => $categoria->nombre, 'slug' => $categoria->slug];
                $query->whereHas('categorias', fn ($q) => $q->where('categorias.id', $categoria->id));
            }
        }

        // Filtro: búsqueda de texto
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn ($q) => $q
                ->where('nombre', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%")
            );
        }

        // Filtro: talla — busca por slug en la relación many-to-many
        if ($request->filled('talla')) {
            $tallaSlug = $request->input('talla');
            $query->whereHas('tallas', fn ($q) => $q->where('tallas.slug', $tallaSlug));
        }

        // Filtro: color — busca por slug en la relación many-to-many
        if ($request->filled('color')) {
            $colorSlug = $request->input('color');
            $query->whereHas('colores', fn ($q) => $q->where('colores.slug', $colorSlug));
        }

        // Ordenamiento
        match ($request->input('orden')) {
            'precio_menor' => $query->orderBy('precio', 'asc'),
            'precio_mayor' => $query->orderBy('precio', 'desc'),
            default => $query->orderByDesc('created_at'),
        };

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

        return view('catalogo.index', compact(
            'productos',
            'categoriaSeleccionada',
            'todasLasTallas',
            'todosLosColores'
        ));
    }

    public function sugerenciasBusqueda(Request $request)
    {
        // Limitar longitud del término para evitar queries LIKE excesivamente largas
        $q = mb_substr(trim((string) $request->query('q', '')), 0, 100);

        if (mb_strlen($q) < 2) {
            return response()->json(['terminos' => [], 'productos' => [], 'total' => 0]);
        }

        // Cacheamos 2 minutos por término: reduce carga en BD cuando varios usuarios
        // escriben el mismo texto o el mismo usuario tipea letra a letra.
        $data = Cache::remember(CacheKeys::busqueda($q), 120, function () use ($q) {
            $where = fn ($query) => $query
                ->where('nombre', 'like', "%{$q}%")
                ->orWhere('descripcion', 'like', "%{$q}%");

            // Query 1: conteo total de coincidencias
            $total = Producto::where('activo', true)->where($where)->count();

            // Query 2: top 5 → primeros 4 como cards, todos sus nombres como términos sugeridos
            $resultados = Producto::where('activo', true)
                ->where($where)
                ->orderBy('nombre')
                ->limit(5)
                ->get(['id', 'nombre', 'slug', 'imagen', 'precio', 'oferta', 'precio_oferta']);

            $terminos = $resultados->pluck('nombre')->values()->toArray();

            $productos = $resultados->take(4)->map(fn ($p) => [
                'nombre' => $p->nombre,
                'slug' => $p->slug,
                'imagen' => $this->urlImagen($p->imagen),
                'precio' => $p->precio,
                'oferta' => (bool) $p->oferta,
                'precio_oferta' => $p->precio_oferta,
                'url' => route('producto', $p->slug),
            ])->values()->toArray();

            return compact('terminos', 'productos', 'total');
        });

        return response()->json($data);
    }

    public function producto($slug)
    {
        // Cacheamos el array de datos del producto 10 minutos.
        // Se invalida desde ProductoObserver (update/delete) y manualmente
        // en destroyImagen (eliminar imagen de galería no dispara el observer).
        $producto = Cache::remember(CacheKeys::producto($slug), 600, function () use ($slug) {
            $p = Producto::with(['categorias', 'imagenes', 'tallas', 'colores', 'detalles', 'sucursales'])
                ->where('slug', $slug)
                ->firstOrFail();

            // Listado de imágenes: principal + galería, máximo 4
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

            return [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'precio' => $p->precio,
                'slug' => $p->slug,
                'descripcion' => $p->descripcion,
                'imagen' => $imagenes[0] ?? $this->urlImagen($p->imagen),
                'imagenes' => $imagenes,
                'oferta' => (bool) $p->oferta,
                'precio_oferta' => $p->precio_oferta,
                'categoria' => $p->categorias->first()?->nombre ?? '',
                'categorias' => $p->categorias->map(fn ($c) => [
                    'id' => $c->id,
                    'nombre' => $c->nombre,
                    'slug' => $c->slug,
                ])->values()->toArray(),
                'categoria_ids' => $p->categorias->pluck('id')->toArray(),
                'tallas' => $p->tallas->pluck('nombre')->values()->toArray(),
                'colores' => $p->colores->map(fn ($c) => [
                    'nombre' => $c->nombre,
                    'hex' => $c->hex,
                ])->values()->toArray(),
                'detalles' => $p->detalles->sortBy('orden')->pluck('texto')->values()->toArray(),
                'sucursales' => $p->sucursales->where('activa', true)->map(fn ($s) => [
                    'id' => $s->id,
                    'nombre' => $s->nombre,
                    'direccion' => $s->direccion,
                    'telefono' => $s->telefono,
                    'horario' => $s->horario,
                ])->values()->toArray(),
            ];
        });

        // Los recomendados cambian con frecuencia (nuevos productos, cambios de categoría)
        // y son distintos por producto, así que se consultan en vivo.
        $recomendados = Producto::with(['categorias', 'imagenes'])
            ->where('activo', true)
            ->where('id', '!=', $producto['id'])
            ->whereHas('categorias', fn ($q) => $q->whereIn('categorias.id', $producto['categoria_ids'])
            )
            ->latest()
            ->limit(8)
            ->get()
            ->map(function ($rp) {
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
                    'categoria' => $rp->categorias->first()?->nombre ?? '',
                    'categorias' => $rp->categorias->pluck('nombre')->implode(', '),
                    'oferta' => (bool) $rp->oferta,
                    'precio_oferta' => $rp->precio_oferta,
                ];
            })->toArray();

        return view('catalogo.show', compact('producto', 'recomendados'));
    }

    public function guiaTallas()
    {
        // Las medidas de tallas cambian raramente → se cachean 30 minutos.
        // Se invalidan automáticamente desde TallaObserver.
        $tallas = Cache::remember(CacheKeys::GUIA_TALLAS, 1800, fn () => Talla::whereNotNull('pecho')
            ->orWhereNotNull('cintura')
            ->orWhereNotNull('cadera')
            ->orWhereNotNull('largo')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get()
        );

        // Determina qué columnas mostrar (solo si al menos una talla tiene valor)
        $mostrarLargo = $tallas->whereNotNull('largo')->isNotEmpty();

        return view('guia-tallas', compact('tallas', 'mostrarLargo'));
    }

    public function nosotros()
    {
        return view('nosotros');
    }

    public function terminos()
    {
        return view('terminos');
    }

    public function privacidad()
    {
        return view('privacidad');
    }
}
