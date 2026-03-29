<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    public function run(): void
    {
        $sucursales = [
            [
                'nombre' => 'Sofis Centro',
                'direccion' => 'Av. Juárez 45, Col. Centro',
                'telefono' => '312-123-4567',
                'horario' => 'Lun – Sáb: 10:00 – 20:00',
                'activa' => true,
            ],
            [
                'nombre' => 'Sofis Plaza',
                'direccion' => 'Blvd. Costero 120, Local 8, Plaza Miramar',
                'telefono' => '312-765-4321',
                'horario' => 'Lun – Dom: 11:00 – 21:00',
                'activa' => true,
            ],
        ];

        foreach ($sucursales as $s) {
            DB::table('sucursales')->updateOrInsert(
                ['nombre' => $s['nombre']],
                array_merge($s, ['created_at' => now(), 'updated_at' => now()])
            );
            $this->command->line("  ✓ {$s['nombre']}");
        }

        $this->command->info('✓ Sucursales creadas');
    }
}
