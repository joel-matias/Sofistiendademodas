<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('accion');           // creado | editado | eliminado | restaurado
            $table->string('modelo_tipo');      // Producto | Categoria | ...
            $table->unsignedBigInteger('modelo_id');
            $table->string('modelo_nombre');    // nombre del registro en el momento del evento
            $table->json('cambios')->nullable(); // [campo => [de => ..., a => ...]]
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
