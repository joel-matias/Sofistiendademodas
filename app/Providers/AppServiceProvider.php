<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Comparte los IDs de favoritos del usuario en todas las vistas
        View::composer('*', function ($view) {
            if (Auth::check() && !Auth::user()->isAdmin()) {
                $view->with('favoritoIds', Auth::user()->favoritos()->pluck('id')->toArray());
            } else {
                $view->with('favoritoIds', []);
            }
        });
    }
}
