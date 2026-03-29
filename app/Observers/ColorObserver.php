<?php

namespace App\Observers;

use App\Models\Color;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class ColorObserver
{
    public function saved(Color $color): void
    {
        Cache::forget(CacheKeys::CATALOGO_COLORES);
    }

    public function deleted(Color $color): void
    {
        Cache::forget(CacheKeys::CATALOGO_COLORES);
    }
}
