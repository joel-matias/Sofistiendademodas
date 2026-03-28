<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Índices en la tabla productos para acelerar las consultas más frecuentes:
        // - Filtro por activo (catálogo público, home)
        // - Filtro por oferta (sección de ofertas)
        // - Orden por created_at (más recientes primero)
        // - Combinado activo + created_at (la query más común del catálogo)
        Schema::table('productos', function (Blueprint $table) {
            $table->index('activo',       'idx_productos_activo');
            $table->index('oferta',       'idx_productos_oferta');
            $table->index('created_at',   'idx_productos_created_at');
            // Índice compuesto para la query más frecuente: WHERE activo=1 ORDER BY created_at DESC
            $table->index(['activo', 'created_at'], 'idx_productos_activo_created');
            // Índice compuesto para filtrar activos con precio (ordenamiento precio asc/desc)
            $table->index(['activo', 'precio'],     'idx_productos_activo_precio');
        });

        // Índice en categorias para búsqueda por slug
        // (ya tiene UNIQUE en slug, que también actúa como índice → no se agrega)

        // Índice en imagenes_producto para acelerar carga de galería por producto
        Schema::table('imagenes_producto', function (Blueprint $table) {
            $table->index(['producto_id', 'orden'], 'idx_imagenes_producto_orden');
        });

        // Índice en favoritos para la consulta de "mis favoritos" por usuario
        Schema::table('favoritos', function (Blueprint $table) {
            $table->index('user_id', 'idx_favoritos_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropIndex('idx_productos_activo');
            $table->dropIndex('idx_productos_oferta');
            $table->dropIndex('idx_productos_created_at');
            $table->dropIndex('idx_productos_activo_created');
            $table->dropIndex('idx_productos_activo_precio');
        });

        Schema::table('imagenes_producto', function (Blueprint $table) {
            $table->dropIndex('idx_imagenes_producto_orden');
        });

        Schema::table('favoritos', function (Blueprint $table) {
            $table->dropIndex('idx_favoritos_user_id');
        });
    }
};
