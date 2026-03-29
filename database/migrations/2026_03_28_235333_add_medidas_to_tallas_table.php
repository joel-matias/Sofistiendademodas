<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campos de medidas a la tabla tallas para la guía de tallas pública.
     * Todos son nullable: una talla puede existir sin medidas si el admin no las ha llenado.
     * Se usa string(20) para permitir tanto valores simples ("86") como rangos ("86-90 cm").
     */
    public function up(): void
    {
        Schema::table('tallas', function (Blueprint $table) {
            // Orden de aparición en la guía (XS=1, S=2, M=3, etc.)
            $table->unsignedSmallInteger('orden')->default(0)->after('slug');

            // Medidas corporales en centímetros (opcionales)
            $table->string('pecho',   20)->nullable()->after('orden');
            $table->string('cintura', 20)->nullable()->after('pecho');
            $table->string('cadera',  20)->nullable()->after('cintura');
            $table->string('largo',   20)->nullable()->after('cadera');
        });
    }

    public function down(): void
    {
        Schema::table('tallas', function (Blueprint $table) {
            $table->dropColumn(['orden', 'pecho', 'cintura', 'cadera', 'largo']);
        });
    }
};
