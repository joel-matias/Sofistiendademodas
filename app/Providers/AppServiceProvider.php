<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    private function configureRateLimiting(): void
    {
        // Login público: 5 intentos por minuto por email+IP (previene brute force)
        RateLimiter::for('login', function (Request $request) {
            return [
                Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip()),
                Limit::perMinute(15)->by($request->ip()),
            ];
        });

        // Login admin: límite más estricto
        RateLimiter::for('admin-login', function (Request $request) {
            return [
                Limit::perMinute(3)->by($request->input('email') . '|' . $request->ip()),
                Limit::perMinute(10)->by($request->ip()),
            ];
        });

        // Registro: 3 cuentas por minuto por IP
        RateLimiter::for('registro', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        // Búsqueda/sugerencias: 60 por minuto por IP
        RateLimiter::for('busqueda', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
