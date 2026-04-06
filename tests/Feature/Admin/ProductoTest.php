<?php

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ── Control de acceso ────────────────────────────────────────────────────────

it('redirige al login público si un invitado intenta acceder al panel de productos', function () {
    // El middleware `auth` intercepta primero y redirige al login público.
    // AdminMiddleware solo actúa sobre usuarios autenticados sin rol admin.
    $this->get(route('admin.productos.index'))
        ->assertRedirect(route('login'));
});

it('redirige al login si un usuario sin rol admin intenta acceder', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.productos.index'))
        ->assertRedirect(route('admin.login'));
});

it('permite al admin ver el listado de productos', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.productos.index'))
        ->assertOk();
});

it('permite al admin ver el formulario de creación', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.productos.create'))
        ->assertOk();
});

// ── Creación de productos ────────────────────────────────────────────────────

it('el admin puede crear un producto con datos válidos', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.productos.store'), [
            'nombre' => 'Vestido elegante negro',
            'precio' => 899,
            'oferta' => false,
            'activo' => true,
        ])->assertRedirect(route('admin.productos.index'));

    $this->assertDatabaseHas('productos', ['nombre' => 'Vestido elegante negro']);
});

it('el slug se genera automáticamente al crear un producto', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post(route('admin.productos.store'), [
        'nombre' => 'Blusa satinada beige',
        'precio' => 450,
        'activo' => true,
    ]);

    $producto = Producto::where('nombre', 'Blusa satinada beige')->first();
    expect($producto->slug)->toStartWith('blusa-satinada-beige');
});

it('el admin no puede crear un producto sin nombre', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post(route('admin.productos.store'), ['precio' => 500])
        ->assertSessionHasErrors('nombre');
});

it('el admin no puede crear un producto sin precio', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post(route('admin.productos.store'), ['nombre' => 'Top negro'])
        ->assertSessionHasErrors('precio');
});

it('el precio de oferta es obligatorio cuando el producto está en oferta', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post(route('admin.productos.store'), [
            'nombre' => 'Falda midi',
            'precio' => 699,
            'oferta' => true,
            // precio_oferta ausente
        ])->assertSessionHasErrors('precio_oferta');
});

it('el precio de oferta debe ser menor al precio regular', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post(route('admin.productos.store'), [
            'nombre'        => 'Blazer estructurado',
            'precio'        => 800,
            'oferta'        => true,
            'precio_oferta' => 900, // mayor al precio
        ])->assertSessionHasErrors('precio_oferta');
});

// ── Edición de productos ─────────────────────────────────────────────────────

it('el admin puede ver el formulario de edición de un producto', function () {
    $producto = Producto::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.productos.edit', $producto))
        ->assertOk();
});

it('el admin puede actualizar un producto', function () {
    $producto = Producto::factory()->create(['nombre' => 'Nombre original']);
    $admin    = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->put(route('admin.productos.update', $producto), [
            'nombre' => 'Nombre actualizado',
            'precio' => $producto->precio,
            'activo' => true,
            'oferta' => false,
        ])->assertRedirect(route('admin.productos.index'));

    $this->assertDatabaseHas('productos', ['nombre' => 'Nombre actualizado']);
});

// ── Eliminación y restauración ───────────────────────────────────────────────

it('el admin puede eliminar (soft-delete) un producto', function () {
    $producto = Producto::factory()->create();
    $admin    = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->delete(route('admin.productos.destroy', $producto))
        ->assertRedirect();

    $this->assertSoftDeleted('productos', ['id' => $producto->id]);
});

it('el admin puede restaurar un producto eliminado', function () {
    $producto = Producto::factory()->create();
    $producto->delete();

    $this->actingAs(User::factory()->admin()->create())
        ->post(route('admin.productos.restore', $producto->id))
        ->assertRedirect();

    $this->assertNotSoftDeleted('productos', ['id' => $producto->id]);
});

it('un usuario sin rol admin no puede crear productos', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('admin.productos.store'), [
            'nombre' => 'Producto no permitido',
            'precio' => 500,
        ])->assertRedirect(route('admin.login'));

    $this->assertDatabaseMissing('productos', ['nombre' => 'Producto no permitido']);
});
