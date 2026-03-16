<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoriaSeeder::class,
            TallaSeeder::class,
            ColorSeeder::class,
            ProductoSeeder::class,
            CoverSeeder::class,
        ]);
    }
}
