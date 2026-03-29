<?php

namespace App\Support;

/**
 * Constantes centralizadas para todas las cache keys del proyecto.
 *
 * Tener los nombres en un solo lugar evita errores de tipeo, facilita
 * buscar qué se está cacheando y hace trivial renombrar una key.
 */
final class CacheKeys
{
    // ── Home ──────────────────────────────────────────────────────────────
    const HOME_CATEGORIAS = 'home_categorias';
    const HOME_COVERS     = 'home_covers';
    const HOME_DESTACADOS = 'home_destacados';

    // ── Catálogo ──────────────────────────────────────────────────────────
    /** Lista de tallas usada en los filtros del catálogo */
    const CATALOGO_TALLAS  = 'catalogo_tallas';
    /** Lista de colores usada en los filtros del catálogo */
    const CATALOGO_COLORES = 'catalogo_colores';

    // ── Guía de tallas ────────────────────────────────────────────────────
    const GUIA_TALLAS = 'guia_tallas';

    // ── Claves dinámicas ──────────────────────────────────────────────────

    /**
     * Cache de la página de detalle de un producto.
     * Se invalida cuando el producto es editado o sus imágenes cambian.
     */
    public static function producto(string $slug): string
    {
        return "producto_{$slug}";
    }

    /**
     * Cache de sugerencias de búsqueda por término.
     * TTL corto (2 min) para mostrar resultados recientes sin saturar la BD.
     */
    public static function busqueda(string $termino): string
    {
        return 'busqueda_' . md5($termino);
    }
}
