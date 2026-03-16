<?php

namespace Database\Seeders;

use App\Models\Cover;
use Illuminate\Database\Seeder;

class CoverSeeder extends Seeder
{
    public function run(): void
    {
        $covers = [
            [
                'titulo'      => 'Moda para tu estilo',
                'subtitulo'   => 'Ropa, calzado y accesorios con diseño y calidad accesible.',
                'texto_boton' => 'Ver catálogo',
                'url_boton'   => '/catalogo',
                'imagen'      => null,
                'orden'       => 1,
                'activo'      => true,
            ],
            [
                'titulo'      => 'Nueva colección',
                'subtitulo'   => 'Descubre las últimas tendencias de la temporada.',
                'texto_boton' => 'Ver novedades',
                'url_boton'   => '/catalogo',
                'imagen'      => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1920&auto=format&fit=crop',
                'orden'       => 2,
                'activo'      => true,
            ],
            [
                'titulo'      => 'Ofertas especiales',
                'subtitulo'   => 'Aprovecha los mejores precios en moda femenina.',
                'texto_boton' => 'Ver ofertas',
                'url_boton'   => '/catalogo?ofertas=1',
                'imagen'      => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=1920&auto=format&fit=crop',
                'orden'       => 3,
                'activo'      => true,
            ],
        ];

        foreach ($covers as $cover) {
            Cover::create($cover);
        }
    }
}
