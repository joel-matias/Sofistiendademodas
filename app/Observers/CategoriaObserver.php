<?php

namespace App\Observers;

use App\Models\Categoria;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class CategoriaObserver
{
    public function saved(Categoria $categoria): void
    {
        Cache::forget(CacheKeys::HOME_CATEGORIAS);
        Cache::forget(CacheKeys::CATALOGO_TALLAS);  // sidebar de filtros muestra categorías
    }

    public function deleted(Categoria $categoria): void
    {
        Cache::forget(CacheKeys::HOME_CATEGORIAS);
        Cache::forget(CacheKeys::CATALOGO_TALLAS);
    }
}
