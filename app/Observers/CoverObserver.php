<?php

namespace App\Observers;

use App\Models\Cover;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class CoverObserver
{
    public function saved(Cover $cover): void
    {
        Cache::forget(CacheKeys::HOME_COVERS);
    }

    public function deleted(Cover $cover): void
    {
        Cache::forget(CacheKeys::HOME_COVERS);
    }
}
