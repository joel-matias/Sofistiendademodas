<?php

namespace Database\Seeders;

use App\Services\ImageService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    public function __construct(private ImageService $imageService) {}

    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Blusas',      'imagen' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Vestidos',    'imagen' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Jeans',       'imagen' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Faldas',      'imagen' => 'https://images.unsplash.com/photo-1583496661160-fb5218cbc86f?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Tops',        'imagen' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Abrigos',     'imagen' => 'https://images.unsplash.com/photo-1539533018257-c4d9f476cfe8?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Calzado',     'imagen' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Accesorios',  'imagen' => 'https://images.unsplash.com/photo-1611085583191-a3b181a88401?q=80&w=1200&auto=format&fit=crop'],
            ['nombre' => 'Ropa',        'imagen' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?q=80&w=1200&auto=format&fit=crop'],
        ];

        foreach ($categorias as $c) {
            $imagenPath = $this->descargarImagen($c['imagen'], 'categorias', 800);

            DB::table('categorias')->updateOrInsert(
                ['slug' => Str::slug($c['nombre'])],
                [
                    'nombre' => $c['nombre'],
                    'slug' => Str::slug($c['nombre']),
                    'descripcion' => null,
                    'imagen' => $imagenPath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $this->command->line("  ✓ {$c['nombre']}");
        }

        $this->command->info('✓ Categorías creadas');
    }

    /**
     * Descarga una imagen remota, la convierte a WebP y devuelve la ruta relativa.
     * Si falla, loguea una advertencia y devuelve la URL original como fallback.
     */
    private function descargarImagen(string $url, string $directorio, int $maxWidth): string
    {
        try {
            return $this->imageService->storeFromUrl($url, $directorio, $maxWidth);
        } catch (\Throwable $e) {
            $this->command->warn("  ⚠ No se pudo convertir imagen: {$url} — {$e->getMessage()}");

            return $url; // fallback: guardar URL original
        }
    }
}
