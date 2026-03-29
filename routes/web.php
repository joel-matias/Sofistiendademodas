<?php

use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\SucursalController;
use App\Http\Controllers\Admin\TallaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PublicAuthController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WishlistController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', [CatalogoController::class, 'home'])->name('home');
Route::get('/catalogo', [CatalogoController::class, 'catalogo'])->name('catalogo');
Route::get('/producto/{slug}', [CatalogoController::class, 'producto'])->name('producto');
Route::get('/nosotros', [CatalogoController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [CatalogoController::class, 'contacto'])->name('contacto');
Route::get('/guia-de-tallas', [CatalogoController::class, 'guiaTallas'])->name('guia-tallas');
Route::get('/buscar/sugerencias', [CatalogoController::class, 'sugerenciasBusqueda'])
    ->middleware('throttle:busqueda')
    ->name('buscar.sugerencias');

Route::get('/login', [PublicAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [PublicAuthController::class, 'login'])->middleware('throttle:login')->name('login.post');
Route::get('/registro', [PublicAuthController::class, 'showRegister'])->name('registro');
Route::post('/registro', [PublicAuthController::class, 'register'])->middleware('throttle:registro')->name('registro.post');
Route::post('/logout', [PublicAuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Verificación de email
    Route::get('/email/verify', function () {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('home')->with('success', '¡Correo verificado! Ya puedes acceder a todas las funciones.');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    })->middleware('throttle:6,1')->name('verification.send');

    // Rutas que requieren email verificado
    Route::middleware('verified')->group(function () {
        Route::get('/mis-favoritos', [WishlistController::class, 'index'])->name('favoritos.index');
        Route::post('/favoritos/{producto}', [WishlistController::class, 'toggle'])->name('favoritos.toggle');
    });
});

Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->middleware('throttle:admin-login')->name('admin.login.post');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('productos', [AdminProductoController::class, 'index'])->name('productos.index');
        Route::get('productos/crear', [AdminProductoController::class, 'create'])->name('productos.create');
        Route::post('productos', [AdminProductoController::class, 'store'])->name('productos.store');
        Route::get('productos/{producto}/editar', [AdminProductoController::class, 'edit'])->name('productos.edit');
        Route::put('productos/{producto}', [AdminProductoController::class, 'update'])->name('productos.update');
        Route::delete('productos/{producto}', [AdminProductoController::class, 'destroy'])->name('productos.destroy');
        Route::post('productos/{id}/restaurar', [AdminProductoController::class, 'restore'])->name('productos.restore');
        Route::delete('productos/{producto}/imagenes/{imagen}', [AdminProductoController::class, 'destroyImagen'])->name('productos.imagenes.destroy');

        Route::get('categorias', [AdminCategoriaController::class, 'index'])->name('categorias.index');
        Route::get('categorias/crear', [AdminCategoriaController::class, 'create'])->name('categorias.create');
        Route::post('categorias', [AdminCategoriaController::class, 'store'])->name('categorias.store');
        Route::get('categorias/{categoria}/editar', [AdminCategoriaController::class, 'edit'])->name('categorias.edit');
        Route::put('categorias/{categoria}', [AdminCategoriaController::class, 'update'])->name('categorias.update');
        Route::delete('categorias/{categoria}', [AdminCategoriaController::class, 'destroy'])->name('categorias.destroy');

        Route::get('tallas', [TallaController::class, 'index'])->name('tallas.index');
        Route::get('tallas/crear', [TallaController::class, 'create'])->name('tallas.create');
        Route::post('tallas', [TallaController::class, 'store'])->name('tallas.store');
        Route::get('tallas/{talla}/editar', [TallaController::class, 'edit'])->name('tallas.edit');
        Route::put('tallas/{talla}', [TallaController::class, 'update'])->name('tallas.update');
        Route::delete('tallas/{talla}', [TallaController::class, 'destroy'])->name('tallas.destroy');

        Route::get('colores', [ColorController::class, 'index'])->name('colores.index');
        Route::get('colores/crear', [ColorController::class, 'create'])->name('colores.create');
        Route::post('colores', [ColorController::class, 'store'])->name('colores.store');
        Route::get('colores/{color}/editar', [ColorController::class, 'edit'])->name('colores.edit');
        Route::put('colores/{color}', [ColorController::class, 'update'])->name('colores.update');
        Route::delete('colores/{color}', [ColorController::class, 'destroy'])->name('colores.destroy');

        Route::get('covers', [CoverController::class, 'index'])->name('covers.index');
        Route::get('covers/crear', [CoverController::class, 'create'])->name('covers.create');
        Route::post('covers', [CoverController::class, 'store'])->name('covers.store');
        Route::post('covers/reorder', [CoverController::class, 'reorder'])->name('covers.reorder');
        Route::get('covers/{cover}/editar', [CoverController::class, 'edit'])->name('covers.edit');
        Route::put('covers/{cover}', [CoverController::class, 'update'])->name('covers.update');
        Route::delete('covers/{cover}', [CoverController::class, 'destroy'])->name('covers.destroy');

        Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::patch('usuarios/{usuario}/role', [UsuarioController::class, 'updateRole'])->name('usuarios.role');

        Route::get('sucursales', [SucursalController::class, 'index'])->name('sucursales.index');
        Route::get('sucursales/crear', [SucursalController::class, 'create'])->name('sucursales.create');
        Route::post('sucursales', [SucursalController::class, 'store'])->name('sucursales.store');
        Route::get('sucursales/{sucursal}/editar', [SucursalController::class, 'edit'])->name('sucursales.edit');
        Route::put('sucursales/{sucursal}', [SucursalController::class, 'update'])->name('sucursales.update');
        Route::delete('sucursales/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');
    });
