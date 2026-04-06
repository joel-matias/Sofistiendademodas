<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Página de login ─────────────────────────────────────────────────────────

it('muestra la página de login del administrador', function () {
    $this->get(route('admin.login'))
        ->assertOk();
});

it('redirige al dashboard si el admin ya está autenticado', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.login'))
        ->assertRedirect(route('admin.dashboard'));
});

// ── Login exitoso ────────────────────────────────────────────────────────────

it('permite el acceso al panel a un administrador con credenciales correctas', function () {
    $admin = User::factory()->admin()->create();

    $this->post(route('admin.login.post'), [
        'email'    => $admin->email,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($admin);
});

// ── Acceso denegado ──────────────────────────────────────────────────────────

it('no permite el acceso al panel a un usuario sin rol admin', function () {
    $user = User::factory()->create(); // role = 'user'

    $this->post(route('admin.login.post'), [
        'email'    => $user->email,
        'password' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('rechaza credenciales incorrectas', function () {
    User::factory()->admin()->create(['email' => 'admin@sofis.com']);

    $this->post(route('admin.login.post'), [
        'email'    => 'admin@sofis.com',
        'password' => 'contraseña-incorrecta',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

// ── Validación de campos ─────────────────────────────────────────────────────

it('requiere el campo email', function () {
    $this->post(route('admin.login.post'), ['password' => 'password'])
        ->assertSessionHasErrors('email');
});

it('requiere un email con formato válido', function () {
    $this->post(route('admin.login.post'), [
        'email'    => 'no-es-un-email',
        'password' => 'password',
    ])->assertSessionHasErrors('email');
});

it('requiere el campo contraseña', function () {
    $this->post(route('admin.login.post'), ['email' => 'admin@sofis.com'])
        ->assertSessionHasErrors('password');
});

// ── Logout ───────────────────────────────────────────────────────────────────

it('cierra la sesión del administrador y redirige al login', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
});
