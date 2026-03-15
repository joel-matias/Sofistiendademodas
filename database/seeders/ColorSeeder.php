<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colores = [
            ['nombre' => 'Negro',         'hex' => '#111111'],
            ['nombre' => 'Blanco',        'hex' => '#FFFFFF'],
            ['nombre' => 'Beige',         'hex' => '#F5F5DC'],
            ['nombre' => 'Crema',         'hex' => '#FFFDD0'],
            ['nombre' => 'Camel',         'hex' => '#C19A6B'],
            ['nombre' => 'Café',          'hex' => '#4B2E2B'],
            ['nombre' => 'Terracota',     'hex' => '#E2725B'],
            ['nombre' => 'Rojo',          'hex' => '#CC2936'],
            ['nombre' => 'Burdeos',       'hex' => '#800020'],
            ['nombre' => 'Coral',         'hex' => '#FF7F50'],
            ['nombre' => 'Rosa',          'hex' => '#F4A7B9'],
            ['nombre' => 'Rosa palo',     'hex' => '#F4C2C2'],
            ['nombre' => 'Fucsia',        'hex' => '#E91E8C'],
            ['nombre' => 'Naranja',       'hex' => '#FF7F11'],
            ['nombre' => 'Mostaza',       'hex' => '#D4A017'],
            ['nombre' => 'Amarillo',      'hex' => '#F7B731'],
            ['nombre' => 'Verde',         'hex' => '#2ECC71'],
            ['nombre' => 'Verde oliva',   'hex' => '#808000'],
            ['nombre' => 'Verde militar', 'hex' => '#4B5320'],
            ['nombre' => 'Azul',          'hex' => '#3B82F6'],
            ['nombre' => 'Azul marino',   'hex' => '#001F5B'],
            ['nombre' => 'Azul cielo',    'hex' => '#87CEEB'],
            ['nombre' => 'Turquesa',      'hex' => '#40E0D0'],
            ['nombre' => 'Morado',        'hex' => '#9B59B6'],
            ['nombre' => 'Lila',          'hex' => '#C8A2C8'],
            ['nombre' => 'Lavanda',       'hex' => '#E6E6FA'],
            ['nombre' => 'Gris',          'hex' => '#8E8E93'],
            ['nombre' => 'Gris claro',    'hex' => '#D3D3D3'],
            ['nombre' => 'Antracita',     'hex' => '#2F2F2F'],
            ['nombre' => 'Plata',         'hex' => '#C0C0C0'],
        ];

        foreach ($colores as $c) {
            $slug = Str::slug($c['nombre']);
            DB::table('colores')->updateOrInsert(
                ['slug' => $slug],
                [
                    'nombre'     => $c['nombre'],
                    'slug'       => $slug,
                    'hex'        => $c['hex'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✓ Colores creados');
    }
}
