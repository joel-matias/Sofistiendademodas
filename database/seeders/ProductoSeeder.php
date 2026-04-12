<?php

namespace Database\Seeders;

use App\Services\ImageService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function __construct(private ImageService $imageService) {}

    public function run(): void
    {
        // ─── Imágenes verificadas ─────────────────────────────────────────────
        // Solo se usan las URLs que el CategoriaSeeder ya etiquetó explícitamente,
        // garantizando que la imagen siempre coincida con el tipo de prenda.
        // Cada clave agrupa variaciones del mismo tipo de prenda.
        $imgs = [
            // Blusas — confirmadas como blusa/camisa
            'blusas' => [
                'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800&q=80&fit=crop&auto=format',
            ],
            // Vestidos — confirmadas como vestido
            'vestidos' => [
                'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=800&q=80&fit=crop&auto=format',
            ],
            // Jeans — confirmada como pantalón denim
            'jeans' => [
                'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80&fit=crop&auto=format',
            ],
            // Faldas — confirmada como falda
            'faldas' => [
                'https://images.unsplash.com/photo-1583496661160-fb5218cbc86f?w=800&q=80&fit=crop&auto=format',
            ],
            // Tops — confirmada como top / camiseta
            'tops' => [
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop&auto=format',
            ],
            // Abrigos — confirmada como abrigo / chamarra
            'abrigos' => [
                'https://images.unsplash.com/photo-1539533018257-c4d9f476cfe8?w=800&q=80&fit=crop&auto=format',
            ],
            // Calzado — las cuatro confirmadas como calzado en el seeder original
            'calzado' => [
                'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800&q=80&fit=crop&auto=format', // sneakers grises
                'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80&fit=crop&auto=format', // tenis de color
                'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=800&q=80&fit=crop&auto=format', // par de zapatos
                'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=800&q=80&fit=crop&auto=format', // tenis blancos
            ],
            // Accesorios — confirmada como accesorios en el CategoriaSeeder
            'accesorios' => [
                'https://images.unsplash.com/photo-1611085583191-a3b181a88401?w=800&q=80&fit=crop&auto=format',
            ],
        ];

        // ─── Pre-descarga y conversión a WebP ────────────────────────────────
        $this->command->line('  Descargando imágenes y convirtiendo a WebP...');
        $urlMap = $this->descargarUrls(array_merge(...array_values($imgs)));
        $this->command->line('  ✓ '.count($urlMap).' imágenes procesadas');

        // Helpers para acceder al mapa de rutas
        $img = fn (string $url): string => $urlMap[$url] ?? $url;

        // ─── Productos ────────────────────────────────────────────────────────
        // Cada producto usa solo la imagen de su propia categoría.
        // La galería usa otras imágenes del mismo grupo cuando hay más de una;
        // cuando solo hay una, la galería queda vacía para no repetir.
        $productos = [

            // ── BLUSAS ────────────────────────────────────────────────────────
            [
                'nombre' => 'Blusa de lino beige',
                'precio' => 429,
                'categorias' => ['Blusas'],
                'img' => $img($imgs['blusas'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L'],
                'colores' => ['Beige', 'Blanco'],
                'desc' => 'Blusa confeccionada en lino natural, fresca y cómoda para el día a día. Corte recto y ligero, ideal para el clima cálido.',
            ],
            [
                'nombre' => 'Blusa floral manga corta',
                'precio' => 389,
                'categorias' => ['Blusas'],
                'img' => $img($imgs['blusas'][0]),
                'galeria' => [],
                'oferta' => true,
                'precio_oferta' => 299,
                'tallas' => ['S', 'M', 'L', 'XL'],
                'colores' => ['Rosa', 'Coral'],
                'desc' => 'Estampado floral delicado, manga corta y tejido suave transpirable. Perfecta para días soleados.',
            ],

            // ── VESTIDOS ──────────────────────────────────────────────────────
            [
                'nombre' => 'Vestido midi floral',
                'precio' => 1199,
                'categorias' => ['Vestidos'],
                'img' => $img($imgs['vestidos'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L'],
                'colores' => ['Rosa palo', 'Crema'],
                'desc' => 'Vestido midi con estampado floral de corte A. Perfecto para ocasiones especiales o paseos de fin de semana.',
            ],
            [
                'nombre' => 'Vestido de playa lino',
                'precio' => 899,
                'categorias' => ['Vestidos'],
                'img' => $img($imgs['vestidos'][0]),
                'galeria' => [],
                'oferta' => true,
                'precio_oferta' => 699,
                'tallas' => ['S', 'M', 'L', 'XL'],
                'colores' => ['Blanco', 'Beige', 'Azul cielo'],
                'desc' => 'Vestido largo de lino, ligero y fresco para la playa o el resort. Escote en V y tirantes ajustables.',
            ],

            // ── JEANS ─────────────────────────────────────────────────────────
            [
                'nombre' => 'Jeans skinny azul oscuro',
                'precio' => 799,
                'categorias' => ['Jeans', 'Ropa'],
                'img' => $img($imgs['jeans'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L', 'XL'],
                'colores' => ['Azul marino'],
                'desc' => 'Jeans skinny de corte ajustado en denim azul oscuro. Talle alto y bolsillos funcionales.',
            ],
            [
                'nombre' => 'Jeans wide leg negro',
                'precio' => 899,
                'categorias' => ['Jeans'],
                'img' => $img($imgs['jeans'][0]),
                'galeria' => [],
                'oferta' => true,
                'precio_oferta' => 699,
                'tallas' => ['S', 'M', 'L'],
                'colores' => ['Negro', 'Antracita'],
                'desc' => 'Jeans de pierna ancha, corte cómodo y tendencia de temporada. Talle alto en tela denim resistente.',
            ],

            // ── FALDAS ────────────────────────────────────────────────────────
            [
                'nombre' => 'Falda midi plisada beige',
                'precio' => 699,
                'categorias' => ['Faldas'],
                'img' => $img($imgs['faldas'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L'],
                'colores' => ['Beige', 'Crema', 'Camel'],
                'desc' => 'Falda midi plisada de caída elegante, perfecta para la oficina o una cena especial. Cierre oculto lateral.',
            ],
            [
                'nombre' => 'Falda mini cuadros',
                'precio' => 599,
                'categorias' => ['Faldas'],
                'img' => $img($imgs['faldas'][0]),
                'galeria' => [],
                'oferta' => true,
                'precio_oferta' => 449,
                'tallas' => ['XS', 'S', 'M'],
                'colores' => ['Negro', 'Blanco'],
                'desc' => 'Clásico estampado de cuadros en falda mini de corte recto. Botones frontales y bolsillos laterales.',
            ],

            // ── TOPS ──────────────────────────────────────────────────────────
            [
                'nombre' => 'Top ribana sin mangas',
                'precio' => 299,
                'categorias' => ['Tops'],
                'img' => $img($imgs['tops'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L', 'XL'],
                'colores' => ['Negro', 'Blanco', 'Burdeos'],
                'desc' => 'Top de ribana ajustado, básico imprescindible para cualquier temporada. Combina con jeans, faldas o blazers.',
            ],
            [
                'nombre' => 'Camiseta básica algodón',
                'precio' => 249,
                'categorias' => ['Tops', 'Ropa'],
                'img' => $img($imgs['tops'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                'colores' => ['Negro', 'Blanco', 'Gris', 'Burdeos', 'Azul marino'],
                'desc' => 'Camiseta básica de algodón pima de 180 g/m², suave al tacto y muy duradera. El esencial que nunca falla.',
            ],

            // ── ABRIGOS ───────────────────────────────────────────────────────
            [
                'nombre' => 'Gabardina camel clásica',
                'precio' => 2499,
                'categorias' => ['Abrigos'],
                'img' => $img($imgs['abrigos'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L', 'XL'],
                'colores' => ['Camel'],
                'desc' => 'Gabardina de corte clásico doble botonadura en tono camel. El básico de temporada que combina con todo.',
            ],
            [
                'nombre' => 'Abrigo lana negro',
                'precio' => 2199,
                'categorias' => ['Abrigos'],
                'img' => $img($imgs['abrigos'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['XS', 'S', 'M', 'L'],
                'colores' => ['Negro'],
                'desc' => 'Abrigo largo de mezcla de lana, cálido y elegante para el invierno. Corte recto con bolsillos laterales.',
            ],

            // ── CALZADO ───────────────────────────────────────────────────────
            // Cuatro imágenes confirmadas de calzado → cada producto usa una diferente
            [
                'nombre' => 'Tenis casuales grises',
                'precio' => 1299,
                'categorias' => ['Calzado'],
                'img' => $img($imgs['calzado'][0]),
                'galeria' => [$img($imgs['calzado'][1])],
                'oferta' => false,
                'tallas' => ['35', '36', '37', '38', '39', '40'],
                'colores' => ['Gris', 'Gris claro'],
                'desc' => 'Tenis de perfil bajo en color gris, cómodos y versátiles para el uso diario. Suela de goma antideslizante.',
            ],
            [
                'nombre' => 'Tenis de colores tendencia',
                'precio' => 1499,
                'categorias' => ['Calzado'],
                'img' => $img($imgs['calzado'][1]),
                'galeria' => [$img($imgs['calzado'][0])],
                'oferta' => true,
                'precio_oferta' => 1199,
                'tallas' => ['35', '36', '37', '38', '39'],
                'colores' => ['Rojo', 'Negro', 'Blanco'],
                'desc' => 'Tenis con diseño vibrante y suela gruesa. El calzado ideal para looks urbanos y street style.',
            ],
            [
                'nombre' => 'Zapatos de vestir clásicos',
                'precio' => 1199,
                'categorias' => ['Calzado'],
                'img' => $img($imgs['calzado'][2]),
                'galeria' => [$img($imgs['calzado'][3])],
                'oferta' => false,
                'tallas' => ['35', '36', '37', '38', '39'],
                'colores' => ['Negro', 'Café', 'Beige'],
                'desc' => 'Zapatos de vestir en piel sintética de calidad, con suela ligera y tacón bajo. Elegantes y cómodos todo el día.',
            ],
            [
                'nombre' => 'Tenis blancos minimalistas',
                'precio' => 999,
                'categorias' => ['Calzado'],
                'img' => $img($imgs['calzado'][3]),
                'galeria' => [$img($imgs['calzado'][0])],
                'oferta' => true,
                'precio_oferta' => 799,
                'tallas' => ['35', '36', '37', '38', '39', '40', '41'],
                'colores' => ['Blanco', 'Crema'],
                'desc' => 'Tenis blancos de diseño limpio y minimalista, esencial del guardarropa moderno. Plantilla acolchonada para mayor confort.',
            ],

            // ── ACCESORIOS ────────────────────────────────────────────────────
            [
                'nombre' => 'Aretes de argolla dorados',
                'precio' => 199,
                'categorias' => ['Accesorios'],
                'img' => $img($imgs['accesorios'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => [],
                'colores' => ['Mostaza', 'Plata'],
                'desc' => 'Aretes de argolla en baño de oro, ligeros y de diseño atemporal. Van perfectos con cualquier look casual o de noche.',
            ],
            [
                'nombre' => 'Collar de cadena fina',
                'precio' => 249,
                'categorias' => ['Accesorios'],
                'img' => $img($imgs['accesorios'][0]),
                'galeria' => [],
                'oferta' => true,
                'precio_oferta' => 179,
                'tallas' => [],
                'colores' => ['Mostaza', 'Plata'],
                'desc' => 'Collar de cadena fina con dije minimalista. Delicado y elegante, ideal para usar solo o en capas.',
            ],

            // ── ROPA (categoría genérica — usa imagen de vestido o blusa) ─────
            [
                'nombre' => 'Conjunto lino pantalón-blusa',
                'precio' => 1299,
                'categorias' => ['Ropa'],
                'img' => $img($imgs['blusas'][0]),
                'galeria' => [],
                'oferta' => false,
                'tallas' => ['S', 'M', 'L'],
                'colores' => ['Beige', 'Blanco'],
                'desc' => 'Conjunto de dos piezas en lino natural: pantalón palazzo de pierna amplia y blusa suelta a juego. Cómodo y elegante.',
            ],
            [
                'nombre' => 'Jumpsuit negro manga larga',
                'precio' => 1199,
                'categorias' => ['Ropa'],
                'img' => $img($imgs['vestidos'][0]),
                'galeria' => [],
                'oferta' => true,
                'precio_oferta' => 949,
                'tallas' => ['XS', 'S', 'M', 'L'],
                'colores' => ['Negro'],
                'desc' => 'Mono largo de manga larga en tela fluida, elegante y práctico para cualquier ocasión. Cintura ajustable con cordón.',
            ],
        ];

        // ─── Mapas de IDs ─────────────────────────────────────────────────────
        $catMap = DB::table('categorias')->pluck('id', 'nombre')->toArray();
        $tallaMap = DB::table('tallas')->pluck('id', 'nombre')->toArray();
        $colorMap = DB::table('colores')->pluck('id', 'nombre')->toArray();
        $sucursalIds = DB::table('sucursales')->where('activa', true)->pluck('id')->toArray();

        foreach ($productos as $p) {
            $slug = Str::slug($p['nombre']).'-'.Str::random(4);

            DB::table('productos')->updateOrInsert(
                ['nombre' => $p['nombre']],
                [
                    'nombre' => $p['nombre'],
                    'slug' => $slug,
                    'descripcion' => $p['desc'],
                    'precio' => $p['precio'],
                    'oferta' => $p['oferta'] ?? false,
                    'precio_oferta' => $p['precio_oferta'] ?? null,
                    'imagen' => $p['img'],
                    'activo' => true,
                    'created_at' => now()->subDays(rand(0, 90)),
                    'updated_at' => now(),
                ]
            );

            $productoId = DB::table('productos')->where('nombre', $p['nombre'])->value('id');

            // Galería
            DB::table('imagenes_producto')->where('producto_id', $productoId)->delete();
            foreach (($p['galeria'] ?? []) as $orden => $url) {
                DB::table('imagenes_producto')->insert([
                    'producto_id' => $productoId,
                    'url' => $url,
                    'orden' => $orden + 1,
                    'principal' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Categorías
            foreach (($p['categorias'] ?? []) as $catNombre) {
                $catId = $catMap[$catNombre] ?? null;
                if ($catId) {
                    DB::table('categoria_producto')->updateOrInsert(
                        ['producto_id' => $productoId, 'categoria_id' => $catId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }

            // Tallas
            foreach (($p['tallas'] ?? []) as $tallaNombre) {
                $tallaId = $tallaMap[$tallaNombre] ?? null;
                if ($tallaId) {
                    DB::table('producto_talla')->updateOrInsert(
                        ['producto_id' => $productoId, 'talla_id' => $tallaId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }

            // Colores
            foreach (($p['colores'] ?? []) as $colorNombre) {
                $colorId = $colorMap[$colorNombre] ?? null;
                if ($colorId) {
                    DB::table('color_producto')->updateOrInsert(
                        ['producto_id' => $productoId, 'color_id' => $colorId],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }

            // Sucursales
            DB::table('producto_sucursal')->where('producto_id', $productoId)->delete();
            $asignadas = count($sucursalIds)
                ? array_slice($sucursalIds, 0, rand(1, count($sucursalIds)))
                : [];
            foreach ($asignadas as $sucursalId) {
                DB::table('producto_sucursal')->insertOrIgnore([
                    'producto_id' => $productoId,
                    'sucursal_id' => $sucursalId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->command->line('  ✓ '.$p['nombre']);
        }

        $this->command->info('✓ '.count($productos).' productos de ejemplo creados');
    }

    /**
     * Descarga y convierte a WebP cada URL única.
     * Retorna mapa URL → ruta local; en caso de fallo usa la URL como fallback.
     *
     * @param  string[]  $urls
     * @return array<string, string>
     */
    private function descargarUrls(array $urls): array
    {
        $map = [];

        foreach (array_unique($urls) as $url) {
            try {
                $map[$url] = $this->imageService->storeFromUrl($url, 'productos', 800);
            } catch (\Throwable $e) {
                $this->command->warn('  ⚠ No se pudo procesar: '.$url.' — '.$e->getMessage());
                $map[$url] = $url;
            }
        }

        return $map;
    }
}
