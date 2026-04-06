<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

// ── Página de registro ───────────────────────────────────────────────────────

it('muestra la página de registro', function () {
    $this->get(route('registro'))
        ->assertOk();
});

it('redirige al home si el usuario ya está autenticado', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('registro'))
        ->assertRedirect(route('home'));
});

// ── Registro exitoso ─────────────────────────────────────────────────────────

it('registra un nuevo usuario y lo redirige a verificar email', function () {
    Event::fake();

    $this->post(route('registro.post'), [
        'name'                  => 'María Pérez',
        'email'                 => 'maria@ejemplo.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect(route('verification.notice'));

    $this->assertDatabaseHas('users', [
        'email' => 'maria@ejemplo.com',
        'role'  => 'user',
    ]);

    $this->assertAuthenticated();
});

it('asigna el rol "user" al registrarse (nunca admin)', function () {
    Event::fake();

    $this->post(route('registro.post'), [
        'name'                  => 'Nuevo Usuario',
        'email'                 => 'nuevo@ejemplo.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ]);

    expect(User::where('email', 'nuevo@ejemplo.com')->value('role'))->toBe('user');
});

// ── Validación de campos ─────────────────────────────────────────────────────

it('requiere el nombre', function () {
    $this->post(route('registro.post'), [
        'email'                 => 'test@ejemplo.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])->assertSessionHasErrors('name');
});

it('requiere un email con formato válido', function () {
    $this->post(route('registro.post'), [
        'name'                  => 'Test',
        'email'                 => 'no-es-email',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])->assertSessionHasErrors('email');
});

it('no permite registrarse con un email ya existente', function () {
    User::factory()->create(['email' => 'existente@ejemplo.com']);

    $this->post(route('registro.post'), [
        'name'                  => 'Otro Usuario',
        'email'                 => 'existente@ejemplo.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])->assertSessionHasErrors('email');
});

it('rechaza contraseñas que no coinciden', function () {
    $this->post(route('registro.post'), [
        'name'                  => 'Test',
        'email'                 => 'test@ejemplo.com',
        'password'              => 'password123',
        'password_confirmation' => 'diferente456',
    ])->assertSessionHasErrors('password');
});

it('requiere contraseña de al menos 8 caracteres', function () {
    $this->post(route('registro.post'), [
        'name'                  => 'Test',
        'email'                 => 'test@ejemplo.com',
        'password'              => 'corta',
        'password_confirmation' => 'corta',
    ])->assertSessionHasErrors('password');
});
