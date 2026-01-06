<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'Camisas',
            'Sudaderas',
            'Pantalones',
            'Vestidos',
        ];

        foreach ($categorias as $nombre) {
            DB::table('categorias')->updateOrInsert(
                ['slug' => Str::slug($nombre)],
                [
                    'nombre' => $nombre,
                    'descripcion' => null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
