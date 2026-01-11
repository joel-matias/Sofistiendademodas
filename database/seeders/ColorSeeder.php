<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colores = [
            ['nombre' => 'Negro', 'hex' => '#000000'],
            ['nombre' => 'Blanco', 'hex' => '#FFFFFF'],
            ['nombre' => 'Marfil', 'hex' => '#FFFFF0'],
            ['nombre' => 'Crema', 'hex' => '#FFFDD0'],
            ['nombre' => 'Beige', 'hex' => '#F5F5DC'],
            ['nombre' => 'Champagne', 'hex' => '#F7E7CE'],
            ['nombre' => 'Arena', 'hex' => '#F4E3C1'],
            ['nombre' => 'Camel', 'hex' => '#C19A6B'],
            ['nombre' => 'Marrón', 'hex' => '#8B4513'],
            ['nombre' => 'Café', 'hex' => '#4B2E2B'],
            ['nombre' => 'Chocolate', 'hex' => '#7B3F00'],
            ['nombre' => 'Terracota', 'hex' => '#E2725B'],
            ['nombre' => 'Cobre', 'hex' => '#B87333'],
            ['nombre' => 'Bronce', 'hex' => '#CD7F32'],

            ['nombre' => 'Rojo', 'hex' => '#FF0000'],
            ['nombre' => 'Rojo oscuro', 'hex' => '#8B0000'],
            ['nombre' => 'Burdeos', 'hex' => '#800020'],
            ['nombre' => 'Granate', 'hex' => '#800000'],
            ['nombre' => 'Carmesí', 'hex' => '#DC143C'],
            ['nombre' => 'Coral', 'hex' => '#FF7F50'],
            ['nombre' => 'Salmon', 'hex' => '#FA8072'],
            ['nombre' => 'Salmon claro', 'hex' => '#FFA07A'],
            ['nombre' => 'Melocotón', 'hex' => '#FFDAB9'],

            ['nombre' => 'Rosa', 'hex' => '#FF69B4'],
            ['nombre' => 'Rosa palo', 'hex' => '#F4C2C2'],
            ['nombre' => 'Rosa viejo', 'hex' => '#C48E8E'],
            ['nombre' => 'Fucsia', 'hex' => '#FF00FF'],
            ['nombre' => 'Magenta', 'hex' => '#FF00BF'],
            ['nombre' => 'Rosa empolvado', 'hex' => '#D6A4A4'],
            ['nombre' => 'Rosa pastel', 'hex' => '#FFD1DC'],

            ['nombre' => 'Naranja', 'hex' => '#FFA500'],
            ['nombre' => 'Naranja oscuro', 'hex' => '#FF8C00'],
            ['nombre' => 'Mandarina', 'hex' => '#FF7F00'],
            ['nombre' => 'Mostaza', 'hex' => '#D4A017'],
            ['nombre' => 'Amarillo', 'hex' => '#FFFF00'],
            ['nombre' => 'Amarillo claro', 'hex' => '#FFFACD'],
            ['nombre' => 'Oro', 'hex' => '#FFD700'],
            ['nombre' => 'Ámbar', 'hex' => '#FFBF00'],

            ['nombre' => 'Verde', 'hex' => '#008000'],
            ['nombre' => 'Verde oscuro', 'hex' => '#006400'],
            ['nombre' => 'Verde bosque', 'hex' => '#228B22'],
            ['nombre' => 'Verde esmeralda', 'hex' => '#50C878'],
            ['nombre' => 'Verde oliva', 'hex' => '#808000'],
            ['nombre' => 'Verde militar', 'hex' => '#4B5320'],
            ['nombre' => 'Verde menta', 'hex' => '#98FF98'],
            ['nombre' => 'Menta pálido', 'hex' => '#CFEEDC'],
            ['nombre' => 'Jade', 'hex' => '#00A86B'],
            ['nombre' => 'Pistacho', 'hex' => '#93C572'],
            ['nombre' => 'Oliva claro', 'hex' => '#B5B35C'],
            ['nombre' => 'Verde agua', 'hex' => '#7FFFD4'],
            ['nombre' => 'Turquesa', 'hex' => '#40E0D0'],
            ['nombre' => 'Teal', 'hex' => '#008080'],
            ['nombre' => 'Verde musgo', 'hex' => '#8A9A5B'],

            ['nombre' => 'Azul', 'hex' => '#0000FF'],
            ['nombre' => 'Azul marino', 'hex' => '#000080'],
            ['nombre' => 'Azul rey', 'hex' => '#4169E1'],
            ['nombre' => 'Azul cielo', 'hex' => '#87CEEB'],
            ['nombre' => 'Azul claro', 'hex' => '#ADD8E6'],
            ['nombre' => 'Azul celeste', 'hex' => '#00BFFF'],
            ['nombre' => 'Azul petróleo', 'hex' => '#013A3A'],
            ['nombre' => 'Azul eléctrico', 'hex' => '#0077FF'],
            ['nombre' => 'Azul petróleo claro', 'hex' => '#2A6F6F'],

            ['nombre' => 'Cian', 'hex' => '#00FFFF'],
            ['nombre' => 'Aqua', 'hex' => '#00FFFF'],
            ['nombre' => 'Turquesa oscuro', 'hex' => '#00CED1'],
            ['nombre' => 'Periwinkle', 'hex' => '#CCCCFF'],

            ['nombre' => 'Morado', 'hex' => '#800080'],
            ['nombre' => 'Violeta', 'hex' => '#8A2BE2'],
            ['nombre' => 'Lila', 'hex' => '#C8A2C8'],
            ['nombre' => 'Lavanda', 'hex' => '#E6E6FA'],
            ['nombre' => 'Malva', 'hex' => '#B784A7'],
            ['nombre' => 'Ciruela', 'hex' => '#8E4585'],
            ['nombre' => 'Berenjena', 'hex' => '#614051'],
            ['nombre' => 'Índigo', 'hex' => '#4B0082'],

            ['nombre' => 'Gris claro', 'hex' => '#D3D3D3'],
            ['nombre' => 'Gris', 'hex' => '#808080'],
            ['nombre' => 'Gris oscuro', 'hex' => '#2F4F4F'],
            ['nombre' => 'Antracita', 'hex' => '#2F2F2F'],
            ['nombre' => 'Plata', 'hex' => '#C0C0C0'],
            ['nombre' => 'Oro rosado', 'hex' => '#B76E79'],
        ];

        foreach ($colores as $c) {
            $slug = Str::slug($c['nombre']);

            DB::table('colores')->updateOrInsert(
                ['slug' => $slug],
                [
                    'nombre' => $c['nombre'],
                    'slug' => $slug,
                    'hex' => $c['hex'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
