<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TallaSeeder extends Seeder
{
    public function run(): void
    {
        $tallas = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '35', '36', '37', '38', '39', '40', '41'];

        foreach ($tallas as $t) {
            DB::table('tallas')->updateOrInsert(
                ['slug' => Str::slug($t)],
                [
                    'nombre'     => $t,
                    'slug'       => Str::slug($t),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✓ Tallas creadas');
    }
}
