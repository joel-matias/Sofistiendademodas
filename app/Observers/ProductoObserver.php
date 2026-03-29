<?php

namespace App\Observers;

use App\Models\Producto;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class ProductoObserver
{
    /**
     * Fired on INSERT and UPDATE.
     * Invalida home y la página de detalle del producto.
     */
    public function saved(Producto $producto): void
    {
        Cache::forget(CacheKeys::HOME_DESTACADOS);
        Cache::forget(CacheKeys::producto($producto->slug));
    }

    /**
     * Fired on soft-delete.
     */
    public function deleted(Producto $producto): void
    {
        Cache::forget(CacheKeys::HOME_DESTACADOS);
        Cache::forget(CacheKeys::producto($producto->slug));
    }

    /**
     * Fired cuando se restaura un producto eliminado (soft-delete).
     */
    public function restored(Producto $producto): void
    {
        Cache::forget(CacheKeys::HOME_DESTACADOS);
        Cache::forget(CacheKeys::producto($producto->slug));
    }
}
