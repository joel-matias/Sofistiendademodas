<?php

namespace Database\Seeders;

use App\Models\Cover;
use App\Services\ImageService;
use Illuminate\Database\Seeder;

class CoverSeeder extends Seeder
{
    public function __construct(private ImageService $imageService) {}

    public function run(): void
    {
        $covers = [
            [
                'titulo' => 'Moda para tu estilo',
                'subtitulo' => 'Ropa, calzado y accesorios con diseño y calidad accesible.',
                'texto_boton' => 'Ver catálogo',
                'url_boton' => '/catalogo',
                'imagen' => null, // sin imagen, usa fondo de color
                'orden' => 1,
                'activo' => true,
            ],
            [
                'titulo' => 'Nueva colección',
                'subtitulo' => 'Descubre las últimas tendencias de la temporada.',
                'texto_boton' => 'Ver novedades',
                'url_boton' => '/catalogo',
                'imagen' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1920&auto=format&fit=crop',
                'orden' => 2,
                'activo' => true,
            ],
            [
                'titulo' => 'Ofertas especiales',
                'subtitulo' => 'Aprovecha los mejores precios en moda femenina.',
                'texto_boton' => 'Ver ofertas',
                'url_boton' => '/catalogo?ofertas=1',
                'imagen' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=1920&auto=format&fit=crop',
                'orden' => 3,
                'activo' => true,
            ],
        ];

        foreach ($covers as $cover) {
            if ($cover['imagen'] !== null) {
                $cover['imagen'] = $this->descargarImagen($cover['imagen'], 'covers', 1400);
            }

            Cover::updateOrCreate(
                ['orden' => $cover['orden']],
                $cover
            );
        }

        $this->command->info('✓ Covers creados');
    }

    private function descargarImagen(string $url, string $directorio, int $maxWidth): string
    {
        try {
            return $this->imageService->storeFromUrl($url, $directorio, $maxWidth);
        } catch (\Throwable $e) {
            $this->command->warn("  ⚠ No se pudo convertir cover: {$url} — {$e->getMessage()}");

            return $url;
        }
    }
}
