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
                'name'     => 'Administrador',
                'email'    => 'admin@sofis.com',
                'password' => bcrypt('admin123'),
                'role'     => 'admin',
            ]
        );

        $usuarios = [
            ['name' => 'María García',    'email' => 'maria@ejemplo.com'],
            ['name' => 'Laura Martínez',  'email' => 'laura@ejemplo.com'],
            ['name' => 'Ana Rodríguez',   'email' => 'ana@ejemplo.com'],
            ['name' => 'Sofía López',     'email' => 'sofia@ejemplo.com'],
        ];

        foreach ($usuarios as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'     => $u['name'],
                    'email'    => $u['email'],
                    'password' => bcrypt('password'),
                    'role'     => 'user',
                ]
            );
        }

        $this->command->info('✓ Usuarios creados (admin@sofis.com / admin123)');
    }
}