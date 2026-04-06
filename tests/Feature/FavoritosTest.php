<?php

use App\Models\Favorito;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Acceso a la página de favoritos ─────────────────────────────────────────

it('redirige a login si el invitado intenta ver favoritos', function () {
    $this->get(route('favoritos.index'))
        ->assertRedirect(route('login'));
});

it('redirige a verificar email si el usuario no ha verificado su cuenta', function () {
    $usuario = User::factory()->unverified()->create();

    $this->actingAs($usuario)
        ->get(route('favoritos.index'))
        ->assertRedirect(route('verification.notice'));
});

it('muestra la página de favoritos a un usuario verificado', function () {
    $usuario = User::factory()->create();

    $this->actingAs($usuario)
        ->get(route('favoritos.index'))
        ->assertOk();
});

it('redirige al home si un admin intenta acceder a favoritos', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('favoritos.index'))
        ->assertRedirect(route('home'));
});

// ── Toggle favorito ──────────────────────────────────────────────────────────

it('un invitado no puede marcar favoritos', function () {
    $producto = Producto::factory()->create();

    $this->postJson(route('favoritos.toggle', $producto))
        ->assertUnauthorized();
});

it('un usuario no verificado no puede marcar favoritos', function () {
    $usuario  = User::factory()->unverified()->create();
    $producto = Producto::factory()->create();

    // postJson indica que espera JSON → el middleware `verified` devuelve 403 en lugar de redirect.
    $this->actingAs($usuario)
        ->postJson(route('favoritos.toggle', $producto))
        ->assertForbidden();
});

it('un usuario verificado puede agregar un producto a favoritos', function () {
    $usuario  = User::factory()->create();
    $producto = Producto::factory()->create();

    $this->actingAs($usuario)
        ->postJson(route('favoritos.toggle', $producto))
        ->assertOk()
        ->assertJson(['favorito' => true, 'count' => 1]);

    $this->assertDatabaseHas('favoritos', [
        'user_id'    => $usuario->id,
        'producto_id' => $producto->id,
    ]);
});

it('un usuario verificado puede quitar un producto de favoritos', function () {
    $usuario  = User::factory()->create();
    $producto = Producto::factory()->create();

    Favorito::create(['user_id' => $usuario->id, 'producto_id' => $producto->id]);

    $this->actingAs($usuario)
        ->postJson(route('favoritos.toggle', $producto))
        ->assertOk()
        ->assertJson(['favorito' => false, 'count' => 0]);

    $this->assertDatabaseMissing('favoritos', [
        'user_id'    => $usuario->id,
        'producto_id' => $producto->id,
    ]);
});

it('el contador refleja el número real de favoritos del usuario', function () {
    $usuario   = User::factory()->create();
    $productos = Producto::factory()->count(3)->create();

    foreach ($productos as $p) {
        Favorito::create(['user_id' => $usuario->id, 'producto_id' => $p->id]);
    }

    // Quita uno → contador debe quedar en 2
    $this->actingAs($usuario)
        ->postJson(route('favoritos.toggle', $productos->first()))
        ->assertJson(['count' => 2]);
});

it('no se crean favoritos duplicados al hacer toggle rápido dos veces', function () {
    $usuario  = User::factory()->create();
    $producto = Producto::factory()->create();

    $this->actingAs($usuario)->postJson(route('favoritos.toggle', $producto)); // agrega
    $this->actingAs($usuario)->postJson(route('favoritos.toggle', $producto)); // quita

    expect(
        Favorito::where('user_id', $usuario->id)->where('producto_id', $producto->id)->count()
    )->toBe(0);
});
