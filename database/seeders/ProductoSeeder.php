<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
     {
        $catMap = DB::table('categorias')->pluck('id', 'nombre');

        $productos = [
            [
                'nombre' => 'Camisa Oversize',
                'slug' => 'camisa-oversize',
                'descripcion' => 'Camisa oversize de algodón premium, cómoda y perfecta para looks casuales.',
                'precio' => 499.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Camisas',
                'oferta' => false,
                'precio_oferta' => null,
            ],
            [
                'nombre' => 'Sudadera Minimal',
                'slug' => 'sudadera-minimal',
                'descripcion' => 'Sudadera minimal en algodón suave, corte relajado.',
                'precio' => 699.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975682031-a0e27ecf41f0?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Sudaderas',
                // Marcamos esta como oferta de ejemplo
                'oferta' => true,
                'precio_oferta' => 599.00,
            ],
            [
                'nombre' => 'Pantalón Cargo',
                'slug' => 'pantalon-cargo',
                'descripcion' => 'Pantalón cargo resistente con múltiples bolsillos.',
                'precio' => 799.00,
                'imagen' => 'https://images.unsplash.com/photo-1514997130083-3e48bd2b2b86?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Pantalones',
                'oferta' => false,
                'precio_oferta' => null,
            ],
            [
                'nombre' => 'Vestido Casual',
                'slug' => 'vestido-casual',
                'descripcion' => 'Vestido casual, ligero y fresco para el día a día.',
                'precio' => 899.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Vestidos',
                'oferta' => false,
                'precio_oferta' => null,
            ],
        ];

        foreach ($productos as $p) {
            DB::table('productos')->updateOrInsert(
                ['slug' => $p['slug']],
                [
                    'nombre' => $p['nombre'],
                    'descripcion' => $p['descripcion'],
                    'precio' => $p['precio'],
                    'oferta' => $p['oferta'],
                    'precio_oferta' => $p['precio_oferta'],
                    'imagen' => $p['imagen'],
                    'categoria_id' => $catMap[$p['categoria']] ?? null,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
