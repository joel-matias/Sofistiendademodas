<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TallaSeeder extends Seeder
{
    public function run(): void
    {
        // Tallas de ropa con medidas para la guía de tallas
        $tallasRopa = [
            ['nombre' => 'XS',  'orden' => 1, 'pecho' => '76-80',  'cintura' => '58-62',  'cadera' => '84-88'],
            ['nombre' => 'S',   'orden' => 2, 'pecho' => '81-85',  'cintura' => '63-67',  'cadera' => '89-93'],
            ['nombre' => 'M',   'orden' => 3, 'pecho' => '86-90',  'cintura' => '68-72',  'cadera' => '94-98'],
            ['nombre' => 'L',   'orden' => 4, 'pecho' => '91-96',  'cintura' => '73-78',  'cadera' => '99-104'],
            ['nombre' => 'XL',  'orden' => 5, 'pecho' => '97-103', 'cintura' => '79-85',  'cadera' => '105-111'],
            ['nombre' => 'XXL', 'orden' => 6, 'pecho' => '104-111','cintura' => '86-93',  'cadera' => '112-119'],
        ];

        // Tallas de calzado (sin medidas de cuerpo)
        $tallasCalzado = ['35', '36', '37', '38', '39', '40', '41'];

        foreach ($tallasRopa as $orden => $data) {
            DB::table('tallas')->updateOrInsert(
                ['slug' => Str::slug($data['nombre'])],
                [
                    'nombre'     => $data['nombre'],
                    'slug'       => Str::slug($data['nombre']),
                    'orden'      => $data['orden'],
                    'pecho'      => $data['pecho'],
                    'cintura'    => $data['cintura'],
                    'cadera'     => $data['cadera'],
                    'largo'      => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        foreach ($tallasCalzado as $i => $t) {
            DB::table('tallas')->updateOrInsert(
                ['slug' => Str::slug($t)],
                [
                    'nombre'     => $t,
                    'slug'       => Str::slug($t),
                    'orden'      => 20 + $i, // aparecen después de la ropa
                    'pecho'      => null,
                    'cintura'    => null,
                    'cadera'     => null,
                    'largo'      => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✓ Tallas creadas');
    }
}
