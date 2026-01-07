<?php

use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogoController::class, 'home'])->name('home');
Route::get('/catalogo', [CatalogoController::class, 'catalogo'])->name('catalogo');
Route::get('/producto/{slug}', [CatalogoController::class, 'producto'])->name('producto');

Route::get('/nosotros', [CatalogoController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [CatalogoController::class, 'contacto'])->name('contacto');
Route::get('/buscar/sugerencias', [CatalogoController::class, 'sugerenciasBusqueda'])->name('buscar.sugerencias');
