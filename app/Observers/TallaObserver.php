<?php

namespace App\Observers;

use App\Models\Talla;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class TallaObserver
{
    public function saved(Talla $talla): void
    {
        Cache::forget(CacheKeys::GUIA_TALLAS);
        Cache::forget(CacheKeys::CATALOGO_TALLAS);
    }

    public function deleted(Talla $talla): void
    {
        Cache::forget(CacheKeys::GUIA_TALLAS);
        Cache::forget(CacheKeys::CATALOGO_TALLAS);
    }
}
