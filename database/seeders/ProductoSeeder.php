<?php

namespace Database\Seeders;

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
        // Mapeo categoría nombre => id
        $catMap = DB::table('categorias')->pluck('id', 'nombre')->toArray();

        $productos = [
            // Blusas
            [
                'nombre' => 'Blusa Seda Floral',
                'precio' => 549.00,
                'imagen' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Blusas',
                'oferta' => false,
            ],
            [
                'nombre' => 'Blusa Lino Verano',
                'precio' => 429.00,
                'imagen' => 'https://images.unsplash.com/photo-1530845645915-0f0b3c9f4b3b?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Blusas',
                'oferta' => true,
                'precio_oferta' => 349.00,
            ],

            // Jeans
            [
                'nombre' => 'Jeans Slim Fit',
                'precio' => 799.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975682071-ae22e7d0f4aa?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Jeans',
                'oferta' => false,
            ],
            [
                'nombre' => 'Jeans Relaxed',
                'precio' => 699.00,
                'imagen' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Jeans',
                'oferta' => false,
            ],

            // Vestidos
            [
                'nombre' => 'Vestido Midi Floral',
                'precio' => 1199.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975957475-5ceea250c40d?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Vestidos',
                'oferta' => false,
            ],
            [
                'nombre' => 'Vestido Casual Playa',
                'precio' => 899.00,
                'imagen' => 'https://images.unsplash.com/photo-1549187774-b4f9b06d8d5a?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Vestidos',
                'oferta' => true,
                'precio_oferta' => 749.00,
            ],

            // Zapatos
            [
                'nombre' => 'Tenis Minimal Blanco',
                'precio' => 1299.00,
                'imagen' => 'https://images.unsplash.com/photo-1528701800489-20be3c2a3ba7?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Zapatos',
                'oferta' => false,
            ],
            [
                'nombre' => 'Botín Cuero Café',
                'precio' => 1399.00,
                'imagen' => 'https://images.unsplash.com/photo-1525773656390-8d2a3b6fcd4b?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Zapatos',
                'oferta' => false,
            ],

            // Calzado (más específico)
            [
                'nombre' => 'Sandalia Plataforma',
                'precio' => 899.00,
                'imagen' => 'https://images.unsplash.com/photo-1490367532201-b9bc1dc483f6?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Calzado',
                'oferta' => true,
                'precio_oferta' => 699.00,
            ],

            // Accesorios
            [
                'nombre' => 'Bolso Bandolera',
                'precio' => 699.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975976508-1b2f4c1d8f39?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Accesorios',
                'oferta' => false,
            ],
            [
                'nombre' => 'Gorra Urbana',
                'precio' => 249.00,
                'imagen' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Accesorios',
                'oferta' => false,
            ],

            // Lo nuevo / Ropa
            [
                'nombre' => 'Chaqueta Bomber Negra',
                'precio' => 1499.00,
                'imagen' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Ropa',
                'oferta' => false,
            ],
            [
                'nombre' => 'Conjunto Deportivo',
                'precio' => 999.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Ropa',
                'oferta' => true,
                'precio_oferta' => 799.00,
            ],

            // Ofertas (productos extra en oferta)
            [
                'nombre' => 'Sudadera Oversize',
                'precio' => 799.00,
                'imagen' => 'https://images.unsplash.com/photo-1520975682031-a0e27ecf41f0?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Ofertas',
                'oferta' => true,
                'precio_oferta' => 599.00,
            ],
            [
                'nombre' => 'Pantalón Chino',
                'precio' => 749.00,
                'imagen' => 'https://images.unsplash.com/photo-1514997130083-3e48bd2b2b86?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Ropa',
                'oferta' => false,
            ],
            [
                'nombre' => 'Vestido Noche',
                'precio' => 1799.00,
                'imagen' => 'https://images.unsplash.com/photo-1503342217505-b0a15a0c7d66?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Vestidos',
                'oferta' => false,
            ],
            [
                'nombre' => 'Sandalia Verano',
                'precio' => 599.00,
                'imagen' => 'https://images.unsplash.com/photo-1490367532201-b9bc1dc483f6?q=80&w=1200&auto=format&fit=crop',
                'categoria' => 'Zapatos',
                'oferta' => false,
            ],
        ];

        foreach ($productos as $p) {
            $slug = Str::slug($p['nombre']);
            $categoriaId = $catMap[$p['categoria']] ?? null;

            DB::table('productos')->updateOrInsert(
                ['slug' => $slug],
                [
                    'nombre' => $p['nombre'],
                    'slug' => $slug,
                    'descripcion' => $p['nombre'].' — descripción breve.',
                    'precio' => $p['precio'],
                    'oferta' => $p['oferta'] ?? false,
                    'precio_oferta' => $p['precio_oferta'] ?? null,
                    'imagen' => $p['imagen'] ?? null,
                    'categoria_id' => $categoriaId,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
