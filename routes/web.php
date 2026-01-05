<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;

Route::get('/', [CatalogoController::class, 'home'])->name('home');
Route::get('/catalogo', [CatalogoController::class, 'catalogo'])->name('catalogo');
Route::get('/producto/{slug}', [CatalogoController::class, 'producto'])->name('producto');

Route::get('/nosotros', [CatalogoController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [CatalogoController::class, 'contacto'])->name('contacto');
