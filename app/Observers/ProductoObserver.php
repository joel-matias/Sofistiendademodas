<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Producto;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductoObserver
{
    /** Campos a excluir del registro de cambios (no aportan información útil). */
    private const IGNORAR = ['updated_at', 'slug'];

    /** Etiquetas legibles en español para los campos del modelo. */
    private const ETIQUETAS = [
        'nombre' => 'Nombre',
        'descripcion' => 'Descripción',
        'precio' => 'Precio',
        'precio_oferta' => 'Precio de oferta',
        'oferta' => 'En oferta',
        'activo' => 'Activo',
        'imagen' => 'Imagen',
    ];

    public function created(Producto $producto): void
    {
        $this->registrar('creado', $producto);

        Cache::forget(CacheKeys::HOME_DESTACADOS);
        Cache::forget(CacheKeys::producto($producto->slug));
    }

    public function updated(Producto $producto): void
    {
        $cambios = $this->extraerCambios($producto);

        if (! empty($cambios)) {
            $this->registrar('editado', $producto, $cambios);
        }

        Cache::forget(CacheKeys::HOME_DESTACADOS);
        Cache::forget(CacheKeys::producto($producto->slug));
    }

    public function deleted(Producto $producto): void
    {
        $this->registrar('eliminado', $producto);

        Cache::forget(CacheKeys::HOME_DESTACADOS);
        Cache::forget(CacheKeys::producto($producto->slug));
    }

    public function restored(Producto $producto): void
    {
        $this->registrar('restaurado', $producto);

        Cache::forget(CacheKeys::HOME_DESTACADOS);
        Cache::forget(CacheKeys::producto($producto->slug));
    }

    // ─────────────────────────────────────────────

    private function registrar(string $accion, Producto $producto, array $cambios = []): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'accion' => $accion,
            'modelo_tipo' => 'Producto',
            'modelo_id' => $producto->id,
            'modelo_nombre' => $producto->nombre,
            'cambios' => empty($cambios) ? null : $cambios,
            'created_at' => now(),
        ]);
    }

    private function extraerCambios(Producto $producto): array
    {
        $cambios = [];

        foreach ($producto->getChanges() as $campo => $valorNuevo) {
            if (in_array($campo, self::IGNORAR, true)) {
                continue;
            }

            $etiqueta = self::ETIQUETAS[$campo] ?? $campo;

            $cambios[$etiqueta] = [
                'de' => $producto->getOriginal($campo),
                'a' => $valorNuevo,
            ];
        }

        return $cambios;
    }
}
