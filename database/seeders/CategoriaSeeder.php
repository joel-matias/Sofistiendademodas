<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Blusas',
                'imagen' => 'https://images.unsplash.com/photo-1520975958225-07d845a6a6b9?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Jeans',
                'imagen' => 'https://images.unsplash.com/photo-1520975682071-ae22e7d0f4aa?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Vestidos',
                'imagen' => 'https://images.unsplash.com/photo-1520975957475-5ceea250c40d?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Zapatos',
                'imagen' => 'https://images.unsplash.com/photo-1528701800489-20be3c2a3ba7?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Ropa',
                'imagen' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Calzado',
                'imagen' => 'https://images.unsplash.com/photo-1542293787938-c9e299b8802b?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Accesorios',
                'imagen' => 'https://images.unsplash.com/photo-1520975976508-1b2f4c1d8f39?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Ofertas',
                'imagen' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
            [
                'nombre' => 'Lo nuevo',
                'imagen' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=1200&auto=format&fit=crop',
                'descripcion' => null,
            ],
        ];

        foreach ($categorias as $c) {
            DB::table('categorias')->updateOrInsert(
                ['slug' => Str::slug($c['nombre'])],
                [
                    'nombre' => $c['nombre'],
                    'descripcion' => $c['descripcion'],
                    // Si la columna imagen existe, la guardamos; si no existe, DB ignorará la clave en updateOrInsert
                    'imagen' => $c['imagen'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
