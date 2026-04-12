<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sofis.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@sofis.com',
                'password' => bcrypt('Sofis2025!'),
                'role' => 'admin',
            ]
        );

        $this->command->info('✓ Admin creado — email: admin@sofis.com / contraseña: Sofis2025!');
        $this->command->warn('  ⚠ Cambia la contraseña del admin después del primer inicio de sesión.');
    }
}
