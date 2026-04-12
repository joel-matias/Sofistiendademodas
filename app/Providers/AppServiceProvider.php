<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Color;
use App\Models\Cover;
use App\Models\Producto;
use App\Models\Talla;
use App\Observers\CategoriaObserver;
use App\Observers\ColorObserver;
use App\Observers\CoverObserver;
use App\Observers\ProductoObserver;
use App\Observers\TallaObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Model Observers — centralizan la invalidación de caché.
        // Cualquier cambio en estos modelos (create/update/delete) invalida
        // automáticamente las keys correspondientes sin tocar los controllers.
        Producto::observe(ProductoObserver::class);
        Categoria::observe(CategoriaObserver::class);
        Talla::observe(TallaObserver::class);
        Color::observe(ColorObserver::class);
        Cover::observe(CoverObserver::class);

        $this->configureRateLimiting();
    }

    private function configureRateLimiting(): void
    {
        // Login público: 5 intentos por minuto por email+IP (previene brute force)
        RateLimiter::for('login', function (Request $request) {
            return [
                Limit::perMinute(5)->by($request->input('email').'|'.$request->ip()),
                Limit::perMinute(15)->by($request->ip()),
            ];
        });

        // Login admin: límite más estricto
        RateLimiter::for('admin-login', function (Request $request) {
            return [
                Limit::perMinute(3)->by($request->input('email').'|'.$request->ip()),
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

        // Reset de contraseña: 5 intentos por minuto por IP (previene spam de emails)
        RateLimiter::for('reset-password', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
